<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\UserCategoryPreference;
use App\Models\Category;
use App\Models\SearchHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BuyerController extends Controller
{
    // Constants for the recommendation algorithm
    const RECENCY_WEIGHT = 0.3;           // How much recent interactions matter (0-1)
    const FREQUENCY_WEIGHT = 0.4;         // How much interaction frequency matters (0-1)
    const ENGAGEMENT_WEIGHT = 0.3;        // How much deeper engagement matters (0-1)
    const DECAY_FACTOR = 0.95;            // Daily decay factor for preferences (0-1)
    const CACHE_MINUTES = 60;             // How long to cache recommendations
    const MAX_RECOMMENDED_PRODUCTS = 10;  // Maximum number of recommended products to show

    /**
     * Display a listing of the resource with improved recommendations.
     */
    public function index()
    {
        $search = request('search');
        $user = auth()->user();
        $categoryFilter = request('category');

        // Get recommended products and categories
        if ($user) {
            $recommended = $this->getRecommendedProducts($user);
            $recommendedProducts = $recommended['products'];
            $preferredCategories = $recommended['categories'];
            $topCategory = $recommended['top_category'];
        } else {
            $recommendedProducts = collect();
            $preferredCategories = [];
            $topCategory = null;
        }

        // Handle search
        if ($search) {
            $products = $this->handleSearchAndUpdatePreferences($search, $user);

            // Refresh recommendations after search
            if ($user) {
                Cache::forget("user_{$user->id}_recommendations");
                $recommended = $this->getRecommendedProducts($user);
                $preferredCategories = $recommended['categories'];
                $topCategory = $recommended['top_category'];
            }
        }
        // Handle category filter
        elseif ($categoryFilter) {
            $products = Product::with('category')
                ->where('category_id', $categoryFilter)
                ->latest()
                ->paginate(12);
        }
        // Show all products with weighted ordering if user is logged in, else show latest products
        else {
            if ($user) {
                $products = Product::with('category')
                    ->leftJoin('user_category_preferences', function ($join) use ($user) {
                        $join->on('products.category_id', '=', 'user_category_preferences.category_id')
                             ->where('user_category_preferences.user_id', $user->id);
                    })
                    ->select('products.*', 'user_category_preferences.weight as user_weight')
                    ->orderByDesc('user_weight')
                    ->orderByDesc('products.created_at')
                    ->paginate(12);
            } else {
                $products = Product::with('category')
                    ->latest()
                    ->paginate(12);
            }
        }

        // Get trending categories (most popular across all users)
        $trendingCategories = $this->getTrendingCategories();

        $recommendedCategoryName = null;
        if ($topCategory) {
            $catObj = Category::find($topCategory);
            $recommendedCategoryName = $catObj ? $catObj->name : $topCategory;
        }

        // Get all categories
        $allCategories = Category::orderBy('name')->get();

        return view('buyer.dashboard', [
            'products' => $products,
            'recommendedCategory' => $topCategory,
            'recommendedCategoryName' => $recommendedCategoryName,
            'preferredCategories' => $preferredCategories,
            'trendingCategories' => $trendingCategories,
            'allCategories' => $allCategories, // Add this line
            'isSearchResults' => !empty($search),
            'searchTerm' => $search,
        ]);
    }

    /**
     * Get recommended products based on user preferences with collaborative filtering.
     */
    private function getRecommendedProducts($user)
    {
        // Try to get from cache first
        return Cache::remember("user_{$user->id}_recommendations", self::CACHE_MINUTES, function () use ($user) {
            // Get user's category preferences
            $userPreferences = $this->getUserCategoryScores($user);

            // If user has no preferences, return empty
            if (empty($userPreferences)) {
                return [
                    'products' => collect(),
                    'categories' => [],
                    'top_category' => null
                ];
            }

            // Get categories sorted by preference score
            $sortedCategories = $userPreferences;
            arsort($sortedCategories);

            // Get products from preferred categories
            $recommendedProducts = $this->getProductsFromPreferredCategories($sortedCategories);

            // Add collaborative filtering recommendations
            $collaborativeRecommendations = $this->getCollaborativeRecommendations($user, $userPreferences);

            // Merge and remove duplicates
            $allRecommendations = $recommendedProducts->merge($collaborativeRecommendations)->unique('id');

            // Sort by relevance score and get paginated results
            $finalRecommendations = $allRecommendations->sortByDesc('relevance_score')->take(self::MAX_RECOMMENDED_PRODUCTS);

            return [
                'products' => $finalRecommendations,
                'categories' => $sortedCategories,
                'top_category' => key($sortedCategories)
            ];
        });
    }

    /**
     * Calculate personalized category scores based on recency, frequency and engagement.
     */
    private function getUserCategoryScores($user)
    {
        // Get raw preferences
        $preferences = UserCategoryPreference::where('user_id', $user->id)
            ->where('weight', '>', 0)
            ->get();

        if ($preferences->isEmpty()) {
            return [];
        }

        $categoryScores = [];

        foreach ($preferences as $pref) {
            // Get category information
            $category = Category::find($pref->category_id);
            if (!$category) continue;

            // Calculate recency factor - how recently did the user interact with this category
            $daysSinceLastInteraction = $pref->updated_at->diffInDays(Carbon::now());
            $recencyFactor = pow(self::DECAY_FACTOR, $daysSinceLastInteraction);

            // Calculate final score using weights
            $score = $pref->weight * $recencyFactor;

            $categoryScores[$category->id] = $score;
        }

        return $categoryScores;
    }

    /**
     * Get products from preferred categories.
     */
    private function getProductsFromPreferredCategories($sortedCategories)
    {
        $categoryIds = array_keys($sortedCategories);
        $totalScore = array_sum($sortedCategories);

        // Get products from top categories
        $products = Product::with('category')
            ->whereIn('category_id', $categoryIds)
            ->latest()
            ->take(50)  // Get a good sample to work with
            ->get();

        // Add relevance score to each product
        return $products->map(function ($product) use ($sortedCategories, $totalScore) {
            $categoryScore = $sortedCategories[$product->category_id] ?? 0;
            $normalizedScore = $totalScore > 0 ? $categoryScore / $totalScore : 0;

            // Add freshness factor - newer products get a boost
            $daysOld = $product->created_at->diffInDays(Carbon::now()) + 1;
            $freshnessFactor = 1 / (log($daysOld + 2, 10) + 1);

            // Add rating factor if available
            $ratingFactor = $product->rating ? ($product->rating / 5) : 0.5;

            // Calculate final relevance score (0-1)
            $relevanceScore = ($normalizedScore * 0.6) + ($freshnessFactor * 0.2) + ($ratingFactor * 0.2);

            $product->relevance_score = $relevanceScore;
            return $product;
        });
    }

    /**
     * Recommend products based on similar users' preferences (collaborative filtering).
     */
    private function getCollaborativeRecommendations($user, $userPreferences)
    {
        // Find users with similar preferences
        $similarUsers = $this->getSimilarUsers($user->id, $userPreferences);

        if (empty($similarUsers)) {
            return collect();
        }

        // Get products that similar users liked but current user hasn't interacted with
        $userCategoryIds = array_keys($userPreferences);

        $similarUserIds = array_keys($similarUsers);

        // Get categories that similar users like but current user hasn't explored
        $recommendedCategories = UserCategoryPreference::whereIn('user_id', $similarUserIds)
            ->whereNotIn('category_id', $userCategoryIds)
            ->where('weight', '>', 10)  // Only consider categories they really like
            ->select('category_id', DB::raw('SUM(weight) as total_weight'))
            ->groupBy('category_id')
            ->orderByDesc('total_weight')
            ->pluck('total_weight', 'category_id')
            ->toArray();

        if (empty($recommendedCategories)) {
            return collect();
        }

        // Get products from these categories
        $products = Product::whereIn('category_id', array_keys($recommendedCategories))
            ->latest()
            ->take(20)
            ->get();

        // Calculate relevance score based on collaborative filtering
        return $products->map(function ($product) use ($recommendedCategories, $similarUsers) {
            $categoryWeight = $recommendedCategories[$product->category_id] ?? 0;
            $maxWeight = max($recommendedCategories);
            $normalizedCategoryWeight = $maxWeight > 0 ? $categoryWeight / $maxWeight : 0;

            // Add freshness and rating factors 
            $daysOld = $product->created_at->diffInDays(Carbon::now()) + 1;
            $freshnessFactor = 1 / (log($daysOld + 2, 10) + 1);
            $ratingFactor = $product->rating ? ($product->rating / 5) : 0.5;

            // Calculate score - slightly lower than direct preferences for exploration/diversity
            $relevanceScore = ($normalizedCategoryWeight * 0.5) + ($freshnessFactor * 0.25) + ($ratingFactor * 0.25);
            $product->relevance_score = $relevanceScore * 0.85; // Slight penalty vs. direct preferences

            return $product;
        });
    }

    /**
     * Find users with similar preferences to the current user.
     */
    private function getSimilarUsers($userId, $userPreferences)
    {
        // Convert user preferences to category_id => weight array
        $categoryIds = array_keys($userPreferences);

        // Find users who have preferences for the same categories
        $potentialSimilarUsers = UserCategoryPreference::whereIn('category_id', $categoryIds)
            ->where('user_id', '!=', $userId)
            ->select('user_id')
            ->distinct()
            ->pluck('user_id')
            ->toArray();

        if (empty($potentialSimilarUsers)) {
            return [];
        }

        // Get their full preferences
        $otherUserPreferences = UserCategoryPreference::whereIn('user_id', $potentialSimilarUsers)
            ->get()
            ->groupBy('user_id');

        // Calculate similarity scores
        $similarityScores = [];

        foreach ($otherUserPreferences as $otherUserId => $preferences) {
            // Convert to category_id => weight array
            $otherUserCategoryPrefs = [];
            foreach ($preferences as $pref) {
                $otherUserCategoryPrefs[$pref->category_id] = $pref->weight;
            }

            // Calculate cosine similarity
            $similarity = $this->calculateSimilarity($userPreferences, $otherUserCategoryPrefs);

            // Only consider if similarity is above threshold
            if ($similarity > 0.2) {
                $similarityScores[$otherUserId] = $similarity;
            }
        }

        // Sort by similarity (highest first)
        arsort($similarityScores);

        // Return top 5 similar users
        return array_slice($similarityScores, 0, 5, true);
    }

    /**
     * Calculate cosine similarity between two users' preferences.
     */
    private function calculateSimilarity($userPrefs1, $userPrefs2)
    {
        // Get all category IDs from both users
        $allCategoryIds = array_unique(array_merge(array_keys($userPrefs1), array_keys($userPrefs2)));

        // Calculate dot product and magnitudes
        $dotProduct = 0;
        $magnitude1 = 0;
        $magnitude2 = 0;

        foreach ($allCategoryIds as $categoryId) {
            $weight1 = $userPrefs1[$categoryId] ?? 0;
            $weight2 = $userPrefs2[$categoryId] ?? 0;

            $dotProduct += $weight1 * $weight2;
            $magnitude1 += $weight1 * $weight1;
            $magnitude2 += $weight2 * $weight2;
        }

        // Prevent division by zero
        if ($magnitude1 == 0 || $magnitude2 == 0) {
            return 0;
        }

        // Return cosine similarity
        return $dotProduct / (sqrt($magnitude1) * sqrt($magnitude2));
    }

    /**
     * Get trending categories across all users.
     */
    private function getTrendingCategories()
    {
        return Cache::remember('trending_categories', 60, function () {
            return UserCategoryPreference::select('category_id', DB::raw('SUM(weight) as total_weight'))
                ->groupBy('category_id')
                ->orderByDesc('total_weight')
                ->take(5)
                ->get()
                ->map(function ($preference) {
                    $category = Category::find($preference->category_id);
                    return [
                        'id' => $preference->category_id,
                        'name' => $category ? $category->name : 'Unknown',
                        'weight' => $preference->total_weight
                    ];
                });
        });
    }

    /**
     * Handle search and update user preferences.
     */
    private function handleSearchAndUpdatePreferences($search, $user)
    {
        // Get direct matches first - only search by name
        $directMatches = Product::with('category')
            ->where('name', 'like', '%' . $search . '%')
            ->latest()
            ->get();

        // Get recommended products (if user is logged in)
        $recommendedProducts = collect();
        if ($user) {
            $recommended = $this->getRecommendedProducts($user);
            $recommendedProducts = $recommended['products']
                ->reject(function($product) use ($directMatches) {
                    return $directMatches->contains('id', $product->id);
                });
        }

        // Same pagination logic continues...
        $directMatches = $directMatches->map(function($product) {
            $product->is_direct_match = true;
            return $product;
        });

        $recommendedProducts = $recommendedProducts->map(function($product) {
            $product->is_direct_match = false;
            return $product;
        });

        // Combine but maintain order (direct matches first)
        $allProducts = $directMatches->concat($recommendedProducts);

        // Convert to paginator
        $perPage = 12;
        $currentPage = request()->get('page', 1);
        $items = $allProducts->forPage($currentPage, $perPage);
        
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $allProducts->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        // Update preferences if user is logged in and products found
        if ($user && $directMatches->isNotEmpty()) {
            $this->updatePreferencesFromSearch($user, $directMatches, $search);
        }

        return $paginator;
    }

    /**
     * Update user preferences based on search results.
     */
    private function updatePreferencesFromSearch($user, $products, $searchTerm)
    {
        // Get category counts from search results
        $categoryCounts = [];
        foreach ($products as $product) {
            if ($product->category_id) {
                $categoryCounts[$product->category_id] = ($categoryCounts[$product->category_id] ?? 0) + 1;
            }
        }

        // Get all user's category preferences
        $allCategories = UserCategoryPreference::where('user_id', $user->id)
            ->pluck('category_id')
            ->toArray();

        // Apply different weight increments based on relevance
        foreach ($categoryCounts as $categoryId => $count) {
            // Calculate search relevance factor based on number of matches
            $relevanceFactor = min(5, $count);

            // Store the search term and category association for future reference
            $this->storeSearchTerm($user->id, $searchTerm, $categoryId, $relevanceFactor);

            // Update user preference
            $preference = UserCategoryPreference::firstOrCreate(
                ['user_id' => $user->id, 'category_id' => $categoryId],
                ['weight' => 0]
            );

            // Higher increment if more products match
            $preference->weight = min(100, $preference->weight + $relevanceFactor);
            $preference->save();
        }

        // Apply decay to non-matching categories
        foreach ($allCategories as $categoryId) {
            if (!isset($categoryCounts[$categoryId])) {
                $pref = UserCategoryPreference::where([
                    'user_id' => $user->id,
                    'category_id' => $categoryId
                ])->first();

                if ($pref && $pref->weight > 0) {
                    $pref->weight = max(0, $pref->weight * self::DECAY_FACTOR);
                    $pref->save();
                }
            }
        }

        // Clear the recommendations cache
        Cache::forget("user_{$user->id}_recommendations");
    }

    /**
     * Store search term for future analysis (can be used for advanced recommendations).
     */
    private function storeSearchTerm($userId, $searchTerm, $categoryId, $relevance)
    {
        // Store search terms for future analysis and smarter recommendations
        \App\Models\SearchHistory::create([
            'user_id' => $userId,
            'search_term' => $searchTerm,
            'category_id' => $categoryId,
            'relevance' => $relevance
        ]);
    }

    /**
     * Show single product and record the view.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        $user = auth()->user();

        if ($user && $product->category_id) {
            // Record a view with higher weight than just a search result
            $preference = UserCategoryPreference::firstOrCreate(
                ['user_id' => $user->id, 'category_id' => $product->category_id],
                ['weight' => 0]
            );

            // Product view gets higher weight than just appearing in search
            $preference->weight = min(100, $preference->weight + 3);
            $preference->save();

            // Clear recommendations cache
            Cache::forget("user_{$user->id}_recommendations");
        }

        // Get related products
        $relatedProducts = $this->getRelatedProducts($product, $user);

        return view('buyer.product-details', [
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }

    /**
     * Get related products for product detail page.
     */
    private function getRelatedProducts($product, $user = null)
    {
        // Strategy for related products:
        // 1. Same category as current product
        // 2. If user logged in, consider their preferences too
        $query = Product::where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->latest();

        // If user is logged in and has preferences, boost products from their other preferred categories
        if ($user) {
            $preferredCategories = UserCategoryPreference::where('user_id', $user->id)
                ->where('category_id', '!=', $product->category_id)
                ->where('weight', '>', 10)
                ->pluck('category_id')
                ->toArray();

            if (!empty($preferredCategories)) {
                // Use union to combine with products from preferred categories
                $preferredQuery = Product::where('id', '!=', $product->id)
                    ->whereIn('category_id', $preferredCategories)
                    ->latest()
                    ->take(3);

                $query = $query->take(3)->union($preferredQuery);
            }
        }

        return $query->take(6)->get();
    }

    /**
     * Reset user recommendations.
     */
    public function resetRecommendations()
    {
        $user = auth()->user();
        if ($user) {
            UserCategoryPreference::where('user_id', $user->id)->delete();
            SearchHistory::where('user_id', $user->id)->delete();
            Cache::forget("user_{$user->id}_recommendations");
        }
        return redirect()->route('buyer.dashboard')->with('status', 'Recommendations have been reset.');
    }

    /**
     * Show all categories with their products.
     */
    public function allCategories()
    {
        $categories = \App\Models\Category::with('products')->get();
        return view('buyer.all-categories', [
            'categories' => $categories,
        ]);
    }

    public function showAccount()
    {
        $user = auth()->user();
        $ordersCount = $user->orders()->count() ?? 0;
        $reviewsCount = $user->reviews()->count() ?? 0;
        $latestOrders = $user->orders()->latest()->take(5)->get();
        $deliveryAddresses = $user->deliveryAddresses; // Fetch all delivery addresses for the user

        // Logic to show the buyer's account details
        return view('buyer.account-profile', compact('user', 'ordersCount', 'reviewsCount', 'latestOrders','deliveryAddresses')); // Return the view for the buyer's account
    }
}

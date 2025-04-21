<?php

namespace App\View\Components;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ReviewProgressBar extends Component
{
    public $ratings;
    public $averageRating;
    public $totalReviews;

    /**
     * Create a new component instance.
     */
    public function __construct(public int $productId)
    {
        $this->calculateRatings();
    }

    /**
     * Calculate the ratings breakdown and overall rating for the product.
     */
    private function calculateRatings(): void
    {
        $product = Product::findOrFail($this->productId);
        $this->totalReviews = $product->reviews->count();
        $this->averageRating = $this->totalReviews > 0
            ? round($product->reviews->avg('rating'), 2)
            : 0;

        $this->ratings = collect(range(1, 5))->map(function ($rating) use ($product) {
            $reviewCount = $product->reviews->where('rating', $rating)->count();
            $percentage = $this->totalReviews > 0 ? ($reviewCount / $this->totalReviews) * 100 : 0;

            return [
                'rating' => $rating,
                'reviewCount' => $reviewCount,
                'percentage' => round($percentage),
            ];
        });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|string
    {
        return view('components.review-progress-bar', [
            'ratings' => $this->ratings,
            'averageRating' => $this->averageRating,
            'totalReviews' => $this->totalReviews,
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //

    public function getAllProducts(Request $request)
    {
        // Logic to retrieve all products for the authenticated seller
        // This is just a placeholder; you would typically fetch products from the database
        $products = Product::all();

        return response()->json($products);
    }
}

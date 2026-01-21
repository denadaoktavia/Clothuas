<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch new arrivals (latest products)
        $newArrivals = Product::where('is_available', true)
            ->latest()
            ->take(8)
            ->get();
        
        // Fetch top selling products (based on lowest stock - best sellers)
        $topSelling = Product::where('is_available', true)
            ->where('stock', '>', 0)
            ->orderBy('stock', 'asc')
            ->take(4)
            ->get();
        
        // Fetch categories
        $categories = Category::withCount('products')
            ->take(6)
            ->get();
        
        return view('pages.home', compact('newArrivals', 'topSelling', 'categories'));
    }
}
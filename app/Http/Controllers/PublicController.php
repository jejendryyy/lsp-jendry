<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Profile;
use App\Models\Product;
use Illuminate\Contracts\View\View;

class PublicController extends Controller
{
    public function home()
    {
        return view('pages.home', [
            'featuredProducts' => Product::with('category')->orderBy('sort_order')->take(4)->get(),
            'previewGalleries' => Gallery::query()->orderBy('sort_order')->latest()->take(4)->get(),
        ]);
    }

    public function profile()
    {
        return view('pages.profile', [
            'profile' => Profile::query()->first(),
        ]);
    }

    public function products()
    {
        $products = Product::with('category')->orderBy('sort_order')->paginate(9);
        return view('pages.products.index', compact('products'));
    }

    public function productDetail(string $slug)
    {
        $product = Product::with('category')->where('slug', $slug)->firstOrFail();
        return view('pages.products.show', compact('product'));
    }

    public function gallery()
    {
        $galleries = Gallery::query()->orderBy('sort_order')->latest()->paginate(12);
        return view('pages.gallery', compact('galleries'));
    }

    public function contact()
    {
        $serviceRequests = auth()->user()
            ?->serviceRequests()
            ->with('product')
            ->latest()
            ->paginate(10);

        return view('pages.contact', [
            'products' => Product::query()->orderBy('name')->get(),
            'serviceRequests' => $serviceRequests,
        ]);
    }
}

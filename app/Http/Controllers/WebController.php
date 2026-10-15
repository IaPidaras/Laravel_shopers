<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class WebController extends Controller
{
    public function catalog(Request $request)
    {
        $query = Product::query();
        if ($request->filled('id_category')) {
            $query->where('id_category', $request->id_category);
        }
        if ($request->filled('sort')) {
            if ($request->sort == 'year') {
                $query->orderBy('year', 'desc');
            } elseif ($request->sort == 'name') {
                $query->orderBy('name', 'asc');
            } elseif ($request->sort == 'cost') {
                $query->orderBy('cost', 'asc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->get();
        $categories = Category::all();

        return view('catalog', compact('products', 'categories'));
    }

   
    public function show($id_product)
    {
        $product = Product::findOrFail($id_product);
        return view('product', compact('product'));
    }
}

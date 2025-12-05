<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->search) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->category) {
            $query->where('category', $request->category);
        }

        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        return $query->paginate(10);
    }

    // POST /api/products
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'price'    => 'required|numeric',
            'category' => 'required',
        ]);

        return Product::create($request->all());
    }
}

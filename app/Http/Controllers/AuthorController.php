<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $books = Product::where('category', 'novel')
            ->orderBy('order_index')
            ->get();

        return view('author.index', compact('books'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class MainPageController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->limit(3)->get();
        $posts = Post::latest()->limit(3)->get();
        return view('welcome', compact('categories', 'posts'));
    }
}

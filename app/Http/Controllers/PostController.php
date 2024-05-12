<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Post::withTrashed()->get();
        return view('dash.posts.all', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('dash.posts.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $locales = LaravelLocalization::getSupportedLocales();

        $rules = [
            'image' => 'required|image',
            'category_id' => 'required',
        ];

        foreach($locales  as $localeCode => $properties) {
            $rules["{$localeCode}.title"] = 'required|string';
            $rules["{$localeCode}.content"] = 'required|string';
            $rules["{$localeCode}.small_description"] = 'required|string';
            $rules["{$localeCode}.tags"] = 'required|string';
        }

        $request->validate($rules);

        $allCategoriesWithoutImages = $request->except(['image']);
        $post = Post::create($allCategoriesWithoutImages);

        if($request->file('image')) {
            $uploadedimage = $post->addMediaFromRequest('image')
            ->toMediaCollection('post_image');

            $post->update([
                'image' => $uploadedimage->getUrl(),
            ]);
        }

        $post->update([
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('dashboard.posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('dash.posts.edit', compact('categories', 'post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $locales = LaravelLocalization::getSupportedLocales();

        $rules = [
            'image' => 'image',
            'category_id' => 'required',
        ];

        foreach($locales  as $localeCode => $properties) {
            $rules["{$localeCode}.title"] = 'required|string';
            $rules["{$localeCode}.content"] = 'required|string';
            $rules["{$localeCode}.small_description"] = 'required|string';
            $rules["{$localeCode}.tags"] = 'required|string';
        }

        $request->validate($rules);

        $allCategoriesWithoutImages = $request->except(['image']);
        $post->update($allCategoriesWithoutImages);

        if($request->file('image')) {
            $oldData = $post->media;
            $oldData[0]->delete();
            $uploadedimage = $post->addMediaFromRequest('image')
            ->toMediaCollection('post_image');

            $post->update([
                'image' => $uploadedimage->getUrl()
            ]);

        }

        return redirect()->route('dashboard.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Post $post)
    {
        $post->delete();
        return redirect()->route('dashboard.posts.index');

    }

    public function restore( Post $post)
    {
        $post->restore();
        return to_route('dashboard.posts.index');
    }
    public function erase( Post $post)
    {
        $post->clearMediaCollection('post_image');
        $post->forceDelete();
        return to_route('dashboard.posts.index');
    }
}

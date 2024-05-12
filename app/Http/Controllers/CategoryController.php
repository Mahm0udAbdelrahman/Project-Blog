<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Category::withTrashed()->get();
        return view('dash.categories.all', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('dash.categories.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $locales = LaravelLocalization::getSupportedLocales();

        $rules = [
            'image' => 'required|image',
            'parent' => 'nullable',
        ];

        foreach($locales  as $localeCode => $properties) {
            $rules["{$localeCode}.title"] = 'required|string';
            $rules["{$localeCode}.content"] = 'required|string';
        }

        $request->validate($rules);

        $allCategoriesWithoutImages = $request->except(['image']);
        $category = Category::create($allCategoriesWithoutImages);

        if($request->file('image')) {
            $uploadedimage = $category->addMediaFromRequest('image')
            ->toMediaCollection('category_image');

            $category->update([
                'image' => $uploadedimage->getUrl()
            ]);
        }

        return redirect()->route('dashboard.categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = Category::all();
        return view('dash.categories.edit', compact('categories', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $locales = LaravelLocalization::getSupportedLocales();

        $rules = [
            'image' => 'image',
            'parent' => 'nullable',
        ];

        foreach($locales  as $localeCode => $properties) {
            $rules["{$localeCode}.title"] = 'required|string';
            $rules["{$localeCode}.content"] = 'required|string';
        }

        $request->validate($rules);

        $allCategoriesWithoutImages = $request->except(['image']);
        $category->update($allCategoriesWithoutImages);

        if($request->file('image')) {
            $oldData = $category->media;
            $oldData[0]->delete();
            $uploadedimage = $category->addMediaFromRequest('image')
            ->toMediaCollection('category_image');

            $category->update([
                'image' => $uploadedimage->getUrl()
            ]);
        }

        return redirect()->route('dashboard.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('dashboard.categories.index');

    }

    public function restore(Category $category)
    {
        $category->restore();
        return to_route('dashboard.categories.index');
    }
    public function erase(Category $category)
    {
        $category->clearMediaCollection('category_image');
        $category->forceDelete();
        return to_route('dashboard.categories.index');
    }
}

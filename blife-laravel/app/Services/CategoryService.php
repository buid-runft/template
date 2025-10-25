<?php

namespace App\Services;

use App\Models\Category;
use App\Services\Core\Contracts\FileStorageInterface;
use Illuminate\Http\Request;

class CategoryService
{
    protected FileStorageInterface $fileStorage;

    public function __construct(FileStorageInterface $fileStorage)
    {
        $this->fileStorage = $fileStorage;
    }

    public function store(Request $request)
    {
        $validated = $request->validated();

        // Handle image upload using FileStorageInterface
        if ($request->hasFile('image')) {
            $validated['image'] = $this->fileStorage->put('categories/' . $request->file('image')->getClientOriginalName(), $request->file('image'));
        }

        return Category::create($validated);
    }
}

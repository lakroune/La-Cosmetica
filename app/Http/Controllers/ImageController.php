<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $images = Image::with('product')->get();
        return response()->json($images, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreImageRequest $request)
    {
        $data = $request->validated();
        $image = Image::create($data);
        return response()->json($image, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image)
    {
        return response()->json($image, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateImageRequest $request, Image $image)
    {
        $data = $request->validated();
        $image->update($data);
        return response()->json($image, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        $image->delete();
        return response()->json(null, 204);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;

class ImageController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreImageRequest $request)
    {
        $data = $request->validated();
        foreach ($data['iamges'] as $imageFile) {
            $path = $imageFile->store('images', 'public');
            Image::create([
                'url' => $path,
                'product_id' => $data['product_id'],
            ]);
        }
        return response()->json(['message' => 'Images uploaded successfully.'], 201);
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

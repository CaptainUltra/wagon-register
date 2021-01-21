<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Http\Requests\StoreImageRequest;
use App\Image;
use App\Http\Resources\Image as ImageResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Image::class, 'image');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreImageRequest  $request
     * @return ImageResource|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function store(StoreImageRequest $request)
    {
        $data = $request->validated();
        $fileContents = $data['file'];

        $data = array_merge($data, [
            'file_name' => ImageHelper::generateFilename($fileContents),
            'user_id' => Auth::user()->id
        ]);

        $image = Image::create($data);
        ImageHelper::storeImageAndCreateThumbnail($fileContents, 500, 500);

        return (new ImageResource($image))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response|ImageResource
     */
    public function show(Image $image)
    {
        return new ImageResource($image);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Image  $image
     * @return ImageResource|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        $image->update($this->validateRequest());

        return (new ImageResource($image))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
    }

    /**
     * Validate data from request.
     *
     * @return mixed
     */
    private function validateRequest()
    {
        return request()->validate([
            'title' => 'required|string',
            'description' => 'sometimes|string',
            'date' => 'sometimes|date'
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\StoreAmenityRequest;
use App\Http\Requests\UpdateAmenityRequest;
use App\Models\Amenity;
use Illuminate\Http\JsonResponse;

class AmenityController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(): JsonResponse
    {
        try {
            $amenities = Amenity::all();
            return $this->sendResponse($amenities, 200, 'Amenities retrieved successfully.');
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 500, 'An error occurred while retrieving amenities.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Amenity  $amenity
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Amenity $amenity): JsonResponse
    {
        return $this->sendResponse($amenity, 200, 'Amenity retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAmenityRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreAmenityRequest $request): JsonResponse
    {
        try {
            $amenity = Amenity::create($request->validated());
            return $this->sendResponse($amenity, 201, 'Amenity created successfully.');
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 500, 'An error occurred while creating the amenity.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAmenityRequest  $request
     * @param  \App\Models\Amenity  $amenity
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAmenityRequest $request, Amenity $amenity): JsonResponse
    {
        try {
            $amenity->update($request->validated());
            return $this->sendResponse($amenity, 200, 'Amenity updated successfully.');
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 500, 'An error occurred while updating the amenity.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Amenity  $amenity
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Amenity $amenity): JsonResponse
    {
        try {
            $amenity->delete();
            return $this->sendResponse(null, 204, 'Amenity deleted successfully.');
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 500, 'An error occurred while deleting the amenity.');
        }
    }
}

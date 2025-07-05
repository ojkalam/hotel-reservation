<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\StoreRoomTypeRequest;
use App\Http\Requests\UpdateRoomTypeRequest;
use App\Models\RoomType;
use Illuminate\Http\JsonResponse;

class RoomTypeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(): JsonResponse
    {
        try {
            $roomTypes = RoomType::all();
            return $this->sendResponse($roomTypes, 200, 'Room types retrieved successfully.');
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 500, 'An error occurred while retrieving room types.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RoomType  $roomType
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(RoomType $roomType): JsonResponse
    {
        try {
            return $this->sendResponse($roomType, 200, 'Room type retrieved successfully.');
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 500, 'An error occurred while retrieving room type.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRoomTypeRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRoomTypeRequest $request): JsonResponse
    {
        try {
            $roomType = RoomType::create($request->validated());
            return $this->sendResponse($roomType, 201, 'Room type created successfully.');
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 500, 'An error occurred while creating the room type.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRoomTypeRequest  $request
     * @param  \App\Models\RoomType  $roomType
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRoomTypeRequest $request, RoomType $roomType): JsonResponse
    {
        try {
            $roomType->update($request->validated());
            return $this->sendResponse($roomType, 200, 'Room type updated successfully.');
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 500, 'An error occurred while updating the room type.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RoomType  $roomType
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(RoomType $roomType): JsonResponse
    {
        try {
            $roomType->delete();
            return $this->sendResponse(null, 204, 'Room type deleted successfully.');
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 500, 'An error occurred while deleting the room type.');
        }
    }
}

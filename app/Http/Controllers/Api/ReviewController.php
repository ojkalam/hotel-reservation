<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use Illuminate\Http\JsonResponse;

class ReviewController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        try {
            $reviews = Review::all();
            return $this->sendResponse(ReviewResource::collection($reviews), 200, 'Reviews retrieved successfully.');
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 500, 'An error occurred while retrieving reviews.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Review $review): JsonResponse
    {
        return $this->sendResponse(new ReviewResource($review), 200, 'Review retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReviewRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreReviewRequest $request): JsonResponse
    {
        try {
            $review = Review::create($request->validated());
            return $this->sendResponse(new ReviewResource($review), 201, 'Review created successfully.');
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 500, 'An error occurred while creating the review.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReviewRequest  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateReviewRequest $request, Review $review): JsonResponse
    {
        try {
            $review->update($request->validated());
            return $this->sendResponse(new ReviewResource($review), 200, 'Review updated successfully.');
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 500, 'An error occurred while updating the review.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Review $review): JsonResponse
    {
        try {
            $review->delete();
            return $this->sendResponse(null, 204, 'Review deleted successfully.');
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 500, 'An error occurred while deleting the review.');
        }
    }
}

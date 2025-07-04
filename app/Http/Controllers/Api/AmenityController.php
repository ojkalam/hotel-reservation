<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\StoreAmenityRequest;
use App\Http\Requests\UpdateAmenityRequest;
use App\Models\Amenity;

class AmenityController extends BaseController
{
    public function list() {
        try {
            $amenities = Amenity::all();
            return $this->sendResponse($amenities, 200);
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage());
        }
    }
    public function show($id) {
        $amenity = Amenity::find($id);
        if (!$amenity) {
            return $this->sendErrorResponse('Amenity Not found.', 404);
        }else{
            return $this->sendResponse($amenity,200);
        }
    }
    public function store(StoreAmenityRequest $request) {
        try {
            $amenity = Amenity::create($request->all());
            return $this->sendResponse($amenity, 201, 'Amenity successfully created.');
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage());
        }
    }
    public function update(UpdateAmenityRequest $request, $id) {
        try {
            $amenity = Amenity::find($id);
            if (!$amenity) {
                return $this->sendErrorResponse('Amenity Not found.', 404);
            }else{
                $data = $request->all();
                $amenity->name = $data['name'];
                $amenity->icon = $data['icon'];
                $amenity->save();
                return $this->sendResponse($amenity, 200, 'Amenity successfully updated.');
            }
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage());
        }

    }
    public function destroy($id) {
        $amenity = Amenity::find($id);
        if (!$amenity) {
            return $this->sendErrorResponse('Amenity not found.', 404);
        } else {
            $amenity->delete();
            return $this->sendResponse('Amenity Deleted Successfully.', 200); //use 204 only when there is nothing to return on body.
        }
    }
}

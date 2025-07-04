<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Models\Hotel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HotelController extends BaseController
{
    public function show($id)
    {
        // Good Practice:
        // $hotel = Hotel::find($id);
        // if (!$hotel) {
        //     return $this->sendErrorResponse('Hotel not found.', 404);
        // } else {
        //      return $this->sendResponse($hotel, 200);
        //  }
        //Acceptable Practice:
        try {
            $hotel = Hotel::findOrFail($id);
            return $this->sendResponse($hotel, 200);
        } catch (ModelNotFoundException $e) {
            return $this->sendErrorResponse($e->getMessage(), 404, 'Not Found.');
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 500);
        }
    }
    public function list()
    {
        try {
            $data = Hotel::take(10)->get();
            return $this->sendResponse($data, 200);
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return $this->sendErrorResponse($validator->errors(), 422, 'Validation Error.');
        }

        try {
            $hotel = Hotel::create($data);
            return $this->sendResponse($hotel, 201, 'Hotel Created Successfully.');
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'country' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendErrorResponse($validator->errors(), 422, 'Validation Error.');
        }

        try {
            $hotel = Hotel::findOrFail($id);
            $hotel->name = $data['name'];
            $hotel->country = $data['country'];
            $hotel->save();
            return $this->sendResponse($hotel, 200, 'Hotel Data Updated.');
        } catch (ModelNotFoundException $e) {
            return $this->sendErrorResponse($e->getMessage(), 404, 'Not Found.');
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage());
        }
    }

    public function destroy($id)
    {
        $hotel = Hotel::find($id);
        if (!$hotel) {
            return $this->sendErrorResponse('Hotel not found.', 404);
        } else {
            $hotel->delete();
            return $this->sendResponse('Hotel Deleted Successfully.', 204); //use 204 only when there is nothing to return on body.
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HotelController extends BaseController
{
    public function list()
    {
        return response()->json(Hotel::take(2)->get());
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()]);
        }
        return response()->json(['status' => true, 'data' => Hotel::create($data)]);
    }
}

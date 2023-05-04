<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate data
        $data = $request->only('user_id', 'product_id', 'comments','star_rating');
        $validator = Validator::make($data, [
            'user_id' => 'required',
            'product_id' => 'required',
            'star_rating' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is valid, create new product
        $product = $this->user->ratings()->create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'comments' => $request->comments,
            'star_rating' => $request->star_rating,
            'status' => $request->status
        ]);

        //Product created, return success response
        return response()->json([
            'success' => true,
            'message' => 'Order created successfully',
            'data' => $product
        ], Response::HTTP_OK);
    }
}

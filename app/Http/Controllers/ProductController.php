<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductInterface;
use App\Mail\RegisterEmail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ProductController extends Controller
{
    private ProductInterface $productRepo;

    public function __construct(ProductInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function index()
    {
        try {

            return response()->json(['products' => $this->productRepo->get()], 200);
        } catch (Exception $e) {

            Log::info("Exception in ProductController@index: " . $e->getMessage());
            return response()->json(['message' => trans('Api.something_wrong')], 404);
        }
    }

    public function show($id)
    {
        try {

            return response()->json(['product' => $this->productRepo->get_item($id)], 200);
        } catch (Exception $e) {

            Log::info("Exception in ProductController@show: " . $e->getMessage());
            return response()->json(['message' => trans('Api.something_wrong')], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'status' => 'required|in:available,out_of_stoke',
            'type' => 'required|in:item,service'
        ]);

        try {

            // get the user from the auth
            // $user = User::first();

            // create the product
            $product = $this->productRepo->create_product($request->only(['name', 'price', 'status', 'type']));

            // seding the email
            // Mail::to($user->email)->send(new RegisterEmail($user));

            return response()->json(['product' => $product], 201);
        } catch (Exception $e) {

            Log::info("Exception in ProductController@create: " . $e->getMessage());
            return response()->json(['message' => trans('Api.something_wrong')], 404);
        }
    }

    public function update($id, Request $request)
    {

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric',
            'status' => 'sometimes|required|in:available,out_of_stoke',
            'type' => 'sometimes|required|in:item,service'
        ]);

        try {

            return response()->json(['product' => $this->productRepo->update_product($id, $request->only(['name', 'price', 'status', 'type']))], 200);
        } catch (Exception $e) {

            Log::info("Exception in ProductController@update: " . $e->getMessage());
            return response()->json(['message' => trans('Api.something_wrong')], 404);
        }
    }

    public function destroy($id)
    {
        try {

            $this->productRepo->delete_product($id);
            return response()->json(null, 204);
        } catch (Exception $e) {

            Log::info("Exception in ProductController@destroy: " . $e->getMessage());
            return response()->json(['message' => trans('Api.something_wrong')], 404);
        }
    }


    public function product_owner($id)
    {
        try {

            return response()->json(['user' => $this->productRepo->get_product_owner_details($id)], 200);
        } catch (Exception $e) {

            Log::info("Exception in ProductController@product_owner: " . $e->getMessage());
            return response()->json(['message' => trans('Api.something_wrong')], 404);
        }
    }

    public function product_changes($id)
    {
        try {

            return response()->json(['product_history' => $this->productRepo->get_product_changes($id)], 200);
        } catch (Exception $e) {

            Log::info("Exception in ProductController@product_changes: " . $e->getMessage());
            return response()->json(['message' => trans('Api.something_wrong')], 404);
        }
    }

    public function product_search($phrase)
    {
        try {

            return response()->json(['products' => $this->productRepo->search($phrase)], 200);
        } catch (Exception $e) {

            Log::info("Exception in ProductController@product_search: " . $e->getMessage());
            return response()->json(['message' => trans('Api.something_wrong')], 404);
        }
    }
}

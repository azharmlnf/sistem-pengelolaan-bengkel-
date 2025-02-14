<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $customers = Customer::latest()->get();
        return response()->json([
            'data' => CustomerResource::collection($customers),
            'message' => 'Fetch all customers',
            'success' => true
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'national_id' => 'required|string|size:16|unique:customers,national_id',
            'address' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $customer = Customer::create([
            'name' => $request->get('name'),
            'national_id' => $request->get('national_id'),
            'address' => $request->get('address')
        ]);

        return response()->json([
            'data' => new CustomerResource($customer),
            'message' => 'Customer created successfully.',
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Customer $customer)
    {
        return response()->json([
            'data' => new CustomerResource($customer),
            'message' => 'Customer data found',
            'success' => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Customer $customer)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'national_id' => 'required|string|size:16|unique:customers,national_id,' . $customer->id,
            'address' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $customer->update([
            'name' => $request->get('name'),
            'national_id' => $request->get('national_id'),
            'address' => $request->get('address')
        ]);

        return response()->json([
            'data' => new CustomerResource($customer),
            'message' => 'Customer updated successfully',
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->json([
            'data' => [],
            'message' => 'Customer deleted successfully',
            'success' => true
        ]);
    }
}

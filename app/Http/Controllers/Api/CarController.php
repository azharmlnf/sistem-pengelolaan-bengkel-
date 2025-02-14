<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarResource;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    /**
     * Tampilkan semua mobil.
     */
    public function index()
    {
        $cars = Car::latest()->get();
        return response()->json([
            'data' => CarResource::collection($cars),
            'message' => 'Fetch all cars',
            'success' => true
        ]);
    }

    /**
     * Simpan data mobil baru.
     */
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'license_plate' => 'required|string|max:10|unique:cars,license_plate',
        'brand' => 'required|string|max:100',
        'type' => 'required|in:Truck,Car,Bus,Trailer,Pickup,Van,other',
        'customer_id' => 'required|exists:customers,id',
        'car_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'data' => [],
            'message' => $validator->errors(),
            'success' => false
        ]);
    }

    // Gunakan form-data untuk gambar
    $imagePath = null;
    if ($request->hasFile('car_image')) {
        $imagePath = $request->file('car_image')->store('cars', 'public');
    }

    $car = Car::create([
        'license_plate' => $request->input('license_plate'),
        'brand' => $request->input('brand'),
        'type' => $request->input('type'),
        'customer_id' => $request->input('customer_id'),
        'car_image' => $imagePath
    ]);

    return response()->json([
        'data' => new CarResource($car),
        'message' => 'Car created successfully.',
        'success' => true
    ]);
}


    /**
     * Tampilkan detail mobil berdasarkan license_plate.
     */
    public function show(Car $car)
    {
        return response()->json([
            'data' => new CarResource($car),
            'message' => 'Car data found',
            'success' => true
        ]);
    }

    /**
     * Update data mobil berdasarkan license_plate.
     */
    public function update(Request $request, Car $car)
    {
        $validator = Validator::make($request->all(), [
            'brand' => 'sometimes|required|string|max:100',
            'type' => 'sometimes|required|in:Truck,Car,Bus,Trailer,Pickup,Van,other',
            'customer_id' => 'sometimes|required|exists:customers,id',
            'car_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        // Hapus gambar lama jika ada gambar baru
        if ($request->hasFile('car_image')) {
            if ($car->car_image) {
                Storage::disk('public')->delete($car->car_image);
            }
            $car->car_image = $request->file('car_image')->store('cars', 'public');
        }

        $car->update($request->except('license_plate', 'car_image'));

        return response()->json([
            'data' => new CarResource($car),
            'message' => 'Car updated successfully',
            'success' => true
        ]);
    }

    /**
     * Hapus mobil berdasarkan license_plate.
     */
    public function destroy(Car $car)
    {
        // Hapus gambar jika ada
        if ($car->car_image) {
            Storage::disk('public')->delete($car->car_image);
        }

        $car->delete();

        return response()->json([
            'data' => [],
            'message' => 'Car deleted successfully',
            'success' => true
        ]);
    }
}

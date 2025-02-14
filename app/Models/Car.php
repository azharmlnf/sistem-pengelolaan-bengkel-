<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    protected $table = 'cars';
    protected $primaryKey = 'license_plate'; // Tentukan primary key yang benar
    public $incrementing = false; // Karena license_plate bukan auto-increment
    protected $keyType = 'string';

    protected $fillable = [
        'license_plate',
        'brand',
        'type',
        'customer_id',
        'car_image',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}

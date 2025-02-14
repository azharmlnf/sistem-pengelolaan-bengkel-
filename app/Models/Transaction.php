<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'total',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($transaction) {
            $transaction->calculateTotal();
        });
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function calculateTotal()
    {
        // Ambil harga service
        $servicePrice = $this->service->price ?? 0;

        // Ambil total harga spare parts dari tabel service_requirements
        $sparePartsTotal = \App\Models\ServiceRequirement::where('service_id', $this->service_id)->sum('total_price');

        // Hitung total
        $this->total = $servicePrice + $sparePartsTotal;
    }
}


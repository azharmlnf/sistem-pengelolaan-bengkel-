<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequirement extends Model
{
    use HasFactory;

    protected $fillable = ['spare_part_id', 'service_id', 'quantity','total_price'];

    public function spare_part()
    {
        return $this->belongsTo(SparePart::class, 'spare_part_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    //hitung otomatis
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($serviceRequirement) {
            if (!$serviceRequirement->spare_part_id || !$serviceRequirement->quantity) {
                return;
            }

            // Ambil harga dari tabel spare_parts
            $sparePart = SparePart::find($serviceRequirement->spare_part_id);

            if ($sparePart) {
                $serviceRequirement->total_price = $serviceRequirement->quantity * $sparePart->price;
            }
        });
    
    }
}


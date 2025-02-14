<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SparePart extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'name',
        'supplier_id',
        'stock',
        'brand',
        'price',
        'sparepart_image'
    ];

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }
}

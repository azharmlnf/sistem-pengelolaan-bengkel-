<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceAssignment extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'service_id',
        'mechanic_id'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function mechanic(){
        return $this->belongsTo(Mechanic::class);
    }
    
}

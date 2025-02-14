<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    use HasFactory;
    protected $fillable= 
    [
        'car_id',
        'entry_date',
        'exit_date',
        'complaint',
        'price',
        'location'
    ];

    public function car(){
        return $this->belongsTo(Car::class,'car_id');
    }

    public function serviceRequirements()
    {
        return $this->hasMany(ServiceRequirement::class, 'service_id');
    }
    
    public function transactions()
    {
        return $this->hasOne(Transaction::class);
    }
    

}

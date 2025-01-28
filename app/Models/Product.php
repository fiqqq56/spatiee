<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 
        'name',
        'description'
    ];

    protected $dates = ['published_at'];

    
    public function getPublishedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }


    protected static function booted()
    {  
        static::creating(function ($product) {
            if (!$product->id) {
                $product->id = (string)  \Illuminate\Support\Str::uuid();
            }
        });
    }

    

    protected $keyType = 'string';

    public $incrementing=false;
}

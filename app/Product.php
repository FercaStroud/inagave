<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $table = 'products';
    public $timestamps = true;

    protected $primaryKey = 'id';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'estate',
        'plant',
        'plant_age',
        'municipality',
        'size_estate',
        'location',
        'location_url',
        'quantity',
        'price',
        'description',
    ];

    protected $hidden = [
    ];


}

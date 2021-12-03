<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Maintenance extends Model
{
    use SoftDeletes;
    protected $table = 'maintenances';
    public $timestamps = true;

    protected $primaryKey = 'id';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'product_id',
        'price',
        'quantity',
        'total',
        'collection_id',
        'collection_status',
        'payment_id',
        'status',
        'payment_type',
        'external_reference',
        'merchant_order_id',
        'preference_id',
        'site_id',
        'processing_mode',
        'merchant_account_id',
        'feedback_status',
        'preference_status',
    ];

    protected $hidden = [
    ];

    public function product(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo('App\Product');
    }
}

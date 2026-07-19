<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'orders';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'order_id';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'invoice_number',
        'customer_name',
        'phone',
        'email',
        'address',
        'latitude',
        'longitude',
        'total_amount',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'total_amount' => 'decimal:2',
        'latitude'     => 'decimal:8',
        'longitude'    => 'decimal:8',
    ];

    /**
     * An order has many order items.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }
}

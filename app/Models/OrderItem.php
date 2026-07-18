<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'order_items';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'order_item_id';

    /**
     * Disable timestamps (order_items has no created_at/updated_at).
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'subtotal',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'price'    => 'decimal:2',
        'subtotal' => 'decimal:2',
        'quantity' => 'integer',
    ];

    /**
     * An order item belongs to an order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    /**
     * An order item belongs to a product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}

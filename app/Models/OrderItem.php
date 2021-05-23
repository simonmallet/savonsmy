<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'category_item_id',
        'quantity',
    ];

    public function categoryItem()
    {
        return $this->belongsTo('App\Models\CategoryItem', 'category_item_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'version_id',
        'client_id',
        'external_uid',
        'status',
        'sent_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany('App\Models\OrderItem', 'order_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function getTotalItemsWithQuantitiesAttribute()
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->quantity;
        }
        return $total;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    const STATUS_DRAFT = 'draft';
    const STATUS_NOT_TREATED = 'not-treated';
    const STATUS_IN_PROGRESS = 'in-progress';
    const STATUS_COMPLETED = 'completed';

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

    public function items()
    {
        return $this->hasMany('App\Models\OrderItem', 'category_id', 'id');
    }
}

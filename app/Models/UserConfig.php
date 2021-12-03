<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserConfig extends Pivot
{
    protected $table = 'user_configs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'value',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

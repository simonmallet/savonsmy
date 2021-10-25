<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'phone_number',
        'email',
        'active',
        'discount_from_retail',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|Client[]
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'user_clients')->using(UserClient::class);
    }
}

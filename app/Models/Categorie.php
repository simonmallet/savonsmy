<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categorie extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'version_id',
        'name',
        'price',
        'enabled',
        'rank',
    ];

    public function items()
    {
        return $this->hasMany('App\Models\CategoryItem', 'category_id', 'id');
    }
}

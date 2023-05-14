<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trackings extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'reference', 'description', 'status'
    ];
    
}

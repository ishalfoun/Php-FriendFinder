<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $table = 'friendships';

    protected $fillable = ['friend1_id', 'friend2_id', 'status'];

    public function friend1()
    {
        return $this->belongsTo('App\User');
    }

    public function friend2()
    {
        return $this->belongsTo('App\User');
    }


}

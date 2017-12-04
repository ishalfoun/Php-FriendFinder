<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $table = 'friendships';
    public $timestamps = false;

    protected $fillable = ['friend1_id', 'friend1_name', 'friend2_id', 'friend2_name', 'status'];

    public function friend1()
    {
        return $this->belongsTo('App\User');
    }

    public function friend2()
    {
        return $this->belongsTo('App\User');
    }


}

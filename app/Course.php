<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'teacher', 'section', 'class', 'title',
    ];

    /**
     * The Slot that belong to the course.
     */
    public function slots()
    {
        return $this->belongsToMany('App\Slot', 'course_slot', 'course_id', 'slot_id');
    }

    /**
     * The Slot that belong to the course.
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}

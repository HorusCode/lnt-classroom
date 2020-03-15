<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = ['user_id','work_id','work_type', 'rate'];


    public function work()
    {
        return $this->morphTo();
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

}

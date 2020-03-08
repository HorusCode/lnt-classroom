<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['group'];

    public function students()
    {
      return $this->hasMany(Student::class);
    }
}

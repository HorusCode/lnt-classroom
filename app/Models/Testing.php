<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testing extends Model
{
    protected $fillable = ['title', 'questions'];

    protected $casts = [
        'questions' => 'array',
    ];

    public function rates()
    {
        return $this->morphMany(Rating::class, 'work');
    }

}

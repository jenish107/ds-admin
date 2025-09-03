<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employ extends Model
{
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function Families()
    {
        return $this->hasMany(Family::class);
    }
}

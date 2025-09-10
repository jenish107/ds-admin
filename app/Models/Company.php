<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public $fillable = ['name', 'email'];
    public function department()
    {
        return $this->hasMany(Department::class);
    }
}

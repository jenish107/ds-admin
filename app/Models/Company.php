<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public $fillable = ['name', 'email'];
    public function countries()
    {
        return $this->hasMany(Department::class);
    }
}

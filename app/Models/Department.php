<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public $fillable = ['name', 'email', 'company_id'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function employs()
    {
        return $this->hasMany(Employ::class);
    }
}

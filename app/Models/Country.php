<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['name'];

    public function states()
    {
        return $this->hasMany(State::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}

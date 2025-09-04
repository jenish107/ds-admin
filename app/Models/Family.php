<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    public $fillable = ['name', 'email', 'employee_id'];
    public function employ()
    {
        return $this->belongsTo(Employ::class);
    }
}

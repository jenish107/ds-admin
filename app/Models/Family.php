<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    public $fillable = ['first_name', 'last_name', 'email', 'employee_id'];
    public function employ()
    {
        return $this->belongsTo(Employ::class);
    }
}

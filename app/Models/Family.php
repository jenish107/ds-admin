<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    public function employ()
    {
        return $this->belongsTo(Employ::class);
    }
}

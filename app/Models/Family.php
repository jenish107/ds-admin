<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    public $fillable = ['full_name', 'email', 'employee_id'];

    public function employ()
    {
        return $this->belongsTo(Employ::class);
    }

    protected function fullNameParts(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                $parts = explode(' ', $attributes['full_name'], 2);
                return [
                    'first_name' => $parts[0] ?? null,
                    'last_name'  => $parts[1] ?? null,
                ];
            }
        );
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            set: fn($value) => $value['first_name'] . ' ' . $value['last_name'],
        );
    }
}

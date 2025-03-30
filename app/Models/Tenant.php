<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = ['name', 'email', 'subdomain', 'status', 'config'];

    protected $casts = [
        'config' => 'array',
    ];
}


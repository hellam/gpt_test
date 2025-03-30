<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalAlert extends Model
{
    use HasFactory;
    protected $fillable = ['type', 'source', 'model', 'model_id', 'message'];
}

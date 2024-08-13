<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modules extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['module_name', 'description','more_permission','status'];
    protected $casts = [
        'status' => 'integer',
      ];
}

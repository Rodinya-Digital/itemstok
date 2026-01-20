<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserServices extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        "services" => "json"
    ];
}

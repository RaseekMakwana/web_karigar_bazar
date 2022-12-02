<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLoginLog extends Model
{
    use HasFactory;

    protected $table = "user_login_log";

    protected $fillable = ['user_id','latitude','longitude'];

    public $timestamps = false;
}

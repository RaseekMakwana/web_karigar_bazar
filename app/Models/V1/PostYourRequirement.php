<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostYourRequirement extends Model
{
    use HasFactory;
    protected $table = "post_your_requirement";

    protected $fillable = ['id','name','mobile','email','message'];


}

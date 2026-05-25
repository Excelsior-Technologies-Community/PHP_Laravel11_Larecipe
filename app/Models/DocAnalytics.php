<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocAnalytics extends Model
{
    protected $fillable = ['version', 'page', 'views', 'likes', 'dislikes'];
}
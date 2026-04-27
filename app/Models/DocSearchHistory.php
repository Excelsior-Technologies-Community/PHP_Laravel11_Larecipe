<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocSearchHistory extends Model
{
    protected $table = 'doc_search_history'; // ✅ IMPORTANT FIX
    protected $fillable = [
        'query',
        'ip_address'
    ];
}
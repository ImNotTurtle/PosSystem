<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryStatusModel extends Model
{
    use HasFactory;

    protected $table = 'category_status';
    protected $fillable = [
        'name',
    ];
}

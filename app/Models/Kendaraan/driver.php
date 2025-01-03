<?php

namespace App\Models\Kendaraan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class driver extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $guarded = [];
}

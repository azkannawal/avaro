<?php

namespace App\Models\DataControl;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tambang extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id';
    protected $guarded = [];
}

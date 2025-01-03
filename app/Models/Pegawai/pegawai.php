<?php

namespace App\Models\Pegawai;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\DataControl\kantor;

class pegawai extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $guarded = [];

    public function kantor()
    {
        return $this->hasOne(kantor::class, 'id', 'penempatan');
    }
}

<?php

namespace App\Models\Kendaraan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class kendaraan extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $guarded = [];

    /**
     * Data jumlah BBM tidak Boleh lebih besar dari full tank
     */
    public function getJumlahBbmAttribute($value)
    {
        if ($value > $this->full_tank) {
            return back()->with('error', 'Jumlah BBM tidak boleh lebih besar dari full tank');
        }
        return $value;
    }
}

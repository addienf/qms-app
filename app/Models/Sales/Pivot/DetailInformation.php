<?php

namespace App\Models\Sales\Pivot;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailInformation extends Model
{
    use HasFactory;

    protected $fillable = ['spesifikasi_product_detail_id', 'file_path'];

    public function spesifikasiProductDetail()
    {
        return $this->belongsTo(SpesifikasiProductDetail::class);
    }
}

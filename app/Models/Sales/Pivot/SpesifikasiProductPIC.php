<?php

namespace App\Models\Sales\Pivot;

use App\Models\Sales\SpesifikasiProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpesifikasiProductPIC extends Model
{
    use HasFactory;

    protected $table = 'spesifikasi_product_pics';

    protected $fillable = ['spesifikasi_product_id', 'pic_signature', 'pic_name'];

    public function spesifikasiProduk()
    {
        return $this->belongsTo(SpesifikasiProduct::class);
    }
}

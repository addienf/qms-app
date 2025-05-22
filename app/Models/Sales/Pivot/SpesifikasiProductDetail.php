<?php

namespace App\Models\Sales\Pivot;

use App\Models\Inventory\Product;
use App\Models\Sales\SpesifikasiProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpesifikasiProductDetail extends Model
{
    use HasFactory;

    protected $fillable = ['spesifikasi_produk_id', 'product_id', 'specification', 'quantity'];

    protected $casts = [
        'specification' => 'array',
    ];

    public function spesifikasi_product()
    {
        return $this->belongsTo(SpesifikasiProduct::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function detailInformation()
    {
        return $this->hasOne(DetailInformation::class);
    }
}

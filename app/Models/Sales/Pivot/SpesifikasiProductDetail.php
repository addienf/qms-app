<?php

namespace App\Models\Sales\Pivot;

use App\Models\Inventory\Product;
use App\Models\Sales\SpesifikasiProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SpesifikasiProductDetail extends Model
{
    use HasFactory;

    protected $fillable = ['spesifikasi_produk_id', 'product_id', 'specification', 'quantity'];

    protected $casts = [
        'specification' => 'array',
    ];

    public function specificationDetail()
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
    protected static function booted()
    {
        static::deleting(function ($model) {
            if ($model->detailInformation) {
                $model->detailInformation->delete();
            }
        });
    }
}

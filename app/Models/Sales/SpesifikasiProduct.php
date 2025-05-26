<?php

namespace App\Models\Sales;

use App\Models\Sales\Pivot\SpesifikasiProductDetail;
use App\Models\Sales\Pivot\SpesifikasiProductPIC;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SpesifikasiProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'urs_id',
        'is_stock',
        'detail_specification',
        'delivery_address',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function urs()
    {
        return $this->belongsTo(URS::class);
    }

    public function productPic()
    {
        return $this->hasOne(SpesifikasiProductPIC::class);
    }

    public function detailSpecifications()
    {
        return $this->hasMany(SpesifikasiProductDetail::class);
    }

    protected static function booted()
    {
        static::deleting(function ($spesifikasi) {
            foreach ($spesifikasi->detailSpecifications as $detail) {
                $detail->delete();
            }

            if ($spesifikasi->productPic) {
                $spesifikasi->productPic->delete();
            }
        });
    }
}

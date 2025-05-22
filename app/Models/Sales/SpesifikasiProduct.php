<?php

namespace App\Models\Sales;

use App\Models\Sales\Pivot\SpesifikasiProductDetail;
use App\Models\Sales\Pivot\SpesifikasiProductPIC;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function productPics()
    {
        return $this->hasMany(SpesifikasiProductPIC::class);
    }

    public function specificationProducts()
    {
        return $this->hasMany(SpesifikasiProductDetail::class);
    }
}

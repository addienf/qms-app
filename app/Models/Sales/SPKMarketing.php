<?php

namespace App\Models\Sales;

use App\Models\Sales\Pivot\SPKMarketingPIC;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SPKMarketing extends Model
{
    use HasFactory;
    protected $table = 'spk_marketings';
    protected $fillable = [
        'spesifikasi_product_id',
        'tanggal',
        'no_order',
        'dari',
        'kepada',
    ];
    protected $casts = [
        'tanggal' => 'date',
    ];
    public function spesifikasiProduct()
    {
        return $this->belongsTo(SpesifikasiProduct::class);
    }
    public function spkMarketingPIC()
    {
        return $this->hasOne(SPKMarketingPIC::class, 'spk_marketing_id');
    }

    protected static function booted()
    {
        static::deleting(function ($spesifikasi) {
            if ($spesifikasi->spkMarketingPIC) {
                $spesifikasi->spkMarketingPIC->delete();
            }
        });
    }
}

<?php

namespace App\Models\Sales\Pivot;

use App\Models\Sales\SpesifikasiProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SpesifikasiProductPIC extends Model
{
    use HasFactory;

    protected $table = 'spesifikasi_product_pics';
    protected $fillable = ['spesifikasi_product_id', 'pic_signature', 'pic_name'];

    public function spesifikasiProduk()
    {
        return $this->belongsTo(SpesifikasiProduct::class);
    }

    public static function convertBase64ToJpg2($base64String, $filename = null, $path)
    {
        if (preg_match('/^data:image\/(png|jpeg|jpg);base64,/', $base64String)) {
            $base64String = preg_replace('/^data:image\/(png|jpeg|jpg);base64,/', '', $base64String);
        }

        // Decode Base64
        $base64String = str_replace(' ', '+', $base64String);
        $imageData = base64_decode($base64String);

        // Simpan ke storage
        Storage::disk('public')->put($path . '/' . $filename, $imageData);

        $newPath = $path . '/' . $filename;

        return $newPath;
    }

    protected static function booted(): void
    {
        static::updating(function ($model) {
            if (
                $model->isDirty('pic_signature') &&
                $model->getOriginal('pic_signature') &&
                Storage::disk('public')->exists($model->getOriginal('pic_signature'))
            ) {
                Storage::disk('public')->delete($model->getOriginal('pic_signature'));
            }
        });

        static::deleting(function ($model) {
            if ($model->pic_signature && Storage::disk('public')->exists($model->pic_signature)) {
                Storage::disk('public')->delete($model->pic_signature);
            }
        });
    }
}

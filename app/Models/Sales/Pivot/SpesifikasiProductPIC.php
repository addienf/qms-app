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

    public static function handleSignature(string $base64String, ?string $oldPath = null): string
    {
        if ($oldPath && Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }

        if (preg_match('/^data:image\/(png|jpe?g);base64,/', $base64String)) {
            $base64String = preg_replace('/^data:image\/(png|jpe?g);base64,/', '', $base64String);
        }

        $base64String = str_replace(' ', '+', $base64String);
        $imageData = base64_decode($base64String);

        $filename = 'signature_' . Str::random(10) . '.jpg';
        $relativePath = 'Sales/Spesifikasi/Signature/' . $filename;

        Storage::disk('public')->put($relativePath, $imageData);

        return $relativePath;
    }

    protected static function booted(): void
    {
        static::deleting(function ($model) {
            if ($model->pic_signature && Storage::disk('public')->exists($model->pic_signature)) {
                Storage::disk('public')->delete($model->pic_signature);
            }
        });
    }
}

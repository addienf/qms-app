<?php

namespace App\Models\Sales\Pivot;

use App\Models\Sales\SPKMarketing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SPKMarketingPIC extends Model
{
    use HasFactory;

    protected $table = 'spk_marketing_pics';
    protected $fillable = [
        'spk_marketing_id',
        'create_name',
        'create_signature',
        'recieve_name',
        'recieve_signature',
    ];

    public function picSPKMarketing()
    {
        return $this->belongsTo(SPKMarketing::class, 'spk_marketing_id');
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
                $model->isDirty('create_signature') &&
                $model->getOriginal('create_signature') &&
                Storage::disk('public')->exists($model->getOriginal('create_signature'))
            ) {
                Storage::disk('public')->delete($model->getOriginal('create_signature'));
            }

            if (
                $model->isDirty('recieve_signature') &&
                $model->getOriginal('recieve_signature') &&
                Storage::disk('public')->exists($model->getOriginal('recieve_signature'))
            ) {
                Storage::disk('public')->delete($model->getOriginal('recieve_signature'));
            }
        });

        static::deleting(function ($model) {
            if ($model->create_signature && Storage::disk('public')->exists($model->create_signature)) {
                Storage::disk('public')->delete($model->create_signature);
            }

            if ($model->recieve_signature && Storage::disk('public')->exists($model->recieve_signature)) {
                Storage::disk('public')->delete($model->recieve_signature);
            }
        });
    }
}

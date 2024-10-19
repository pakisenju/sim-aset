<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestockRequest extends Model
{
    use HasFactory;

    protected $table = 'restock_requests';
    protected $primaryKey = 'id';

    protected $enumStatus = ['Proses', 'Tolak', 'Terima', 'Selesai'];

    protected $fillable = [
        'assets_id',
        'description',
        'evidance',
        'status',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'assets_id');
    }

    public static function getStatusOptions()
    {
        return [
            'Proses',
            'Tolak',
            'Terima',
            'Selesai',
        ];
    }
}

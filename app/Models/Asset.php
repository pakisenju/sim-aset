<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $table = 'assets';
    protected $primaryKey = 'id';

    protected $fillable = [
        'supplier_id',
        'product_name',
        'brand_name',
        'thumbnail',
        'quantity',
    ];

    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }

    public function restockRequests()
    {
        return $this->hasMany(RestockRequest::class, 'assets_id');
    }
}

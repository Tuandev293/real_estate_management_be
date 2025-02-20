<?php

namespace App\Models;

use App\Helper\BuildingUtils;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Building extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_building',
        'address',
        'room_number',
        'price',
        'image'
    ];

    protected $appends = ['url_image', 'formatted_price'];

    public function getUrlImageAttribute()
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }

    public function getFormattedPriceAttribute()
    {
        return BuildingUtils::formatPrice($this->price);
    }
}

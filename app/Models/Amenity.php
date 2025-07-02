<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Room;
class Amenity extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'room_amenities', 'amenity_id', 'room_id');
    }
}

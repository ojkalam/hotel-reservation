<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BookingRoom;
use App\Models\Hotel;
use App\Models\Amenity;
use App\Models\RoomType;
class Room extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }
    public function bookingRooms()
    {
        return $this->hasMany(BookingRoom::class, 'room_id', 'id');
    }
    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'room_amenities', 'room_id', 'amenity_id');
    }
}

<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Room;
class BookingRoom extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}

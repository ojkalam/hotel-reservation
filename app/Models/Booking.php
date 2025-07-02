<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\BookingRoom;
use App\Models\Payment;
class Booking extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function user()
    {
        //This means: the booking belongs to a user through user_id.
        return $this->belongsTo(User::class);
    }
    public function bookingRooms()
    {
        return $this->hasMany(BookingRoom::class);
    }
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}

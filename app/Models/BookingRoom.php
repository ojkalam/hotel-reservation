<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Room;
/**
 * 
 *
 * @property int $id
 * @property int $booking_id
 * @property int $room_id
 * @property string $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Booking $booking
 * @property-read Room $room
 * @method static \Database\Factories\BookingRoomFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookingRoom newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookingRoom newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookingRoom query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookingRoom whereBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookingRoom whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookingRoom whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookingRoom wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookingRoom whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookingRoom whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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

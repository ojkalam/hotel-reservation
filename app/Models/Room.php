<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BookingRoom;
use App\Models\Hotel;
use App\Models\Amenity;
use App\Models\RoomType;
/**
 * 
 *
 * @property int $id
 * @property int $hotel_id
 * @property int $room_type_id
 * @property string $room_number
 * @property int $floor
 * @property int $is_available
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Amenity> $amenities
 * @property-read int|null $amenities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, BookingRoom> $bookingRooms
 * @property-read int|null $booking_rooms_count
 * @property-read Hotel $hotel
 * @property-read RoomType $roomType
 * @method static \Database\Factories\RoomFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Room newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Room newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Room query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Room whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Room whereFloor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Room whereHotelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Room whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Room whereIsAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Room whereRoomNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Room whereRoomTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Room whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Room extends Model
{
    use HasFactory;
    protected $fillable = [
        'hotel_id',
        'room_type_id',
        'room_number',
        'floor',
        'is_available',
    ];

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

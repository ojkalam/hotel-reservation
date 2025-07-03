<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hotel;
use App\Models\Room;
/**
 * 
 *
 * @property int $id
 * @property int $hotel_id
 * @property string $type_name
 * @property string|null $description
 * @property int $max_occupancy
 * @property string $price_per_night
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Hotel $hotel
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Room> $rooms
 * @property-read int|null $rooms_count
 * @method static \Database\Factories\RoomTypeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoomType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoomType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoomType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoomType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoomType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoomType whereHotelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoomType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoomType whereMaxOccupancy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoomType wherePricePerNight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoomType whereTypeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoomType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RoomType extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
    
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}

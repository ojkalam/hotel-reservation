<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RoomType;
use App\Models\Room;

/**
 *
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $address
 * @property string|null $city
 * @property string|null $country
 * @property string|null $zipcode
 * @property string $rating
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, RoomType> $roomTypes
 * @property-read int|null $room_types_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Room> $rooms
 * @property-read int|null $rooms_count
 * @method static \Database\Factories\HotelFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hotel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hotel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hotel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hotel whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hotel whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hotel whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hotel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hotel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hotel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hotel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hotel whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hotel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hotel whereZipcode($value)
 * @mixin \Eloquent
 */
class Hotel extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function roomTypes()
    {
        return $this->hasMany(RoomType::class);
    }
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}

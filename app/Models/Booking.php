<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\BookingRoom;
use App\Models\Payment;
/**
 * 
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $guest_name
 * @property string|null $guest_phone
 * @property string $booking_type
 * @property string|null $check_in_date
 * @property string|null $check_out_date
 * @property int $guest_count
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, BookingRoom> $bookingRooms
 * @property-read int|null $booking_rooms_count
 * @property-read Payment|null $payment
 * @property-read User|null $user
 * @method static \Database\Factories\BookingFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereBookingType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereCheckInDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereCheckOutDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereGuestCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereGuestName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereGuestPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereUserId($value)
 * @mixin \Eloquent
 */
class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'guest_name',
        'guest_phone',
        'booking_type',
        'check_in_date',
        'check_out_date',
        'guest_count',
        'status',
    ];
    
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

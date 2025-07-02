<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RoomType;
use App\Models\Room;

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

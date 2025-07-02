<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hotel;
use App\Models\Room;
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

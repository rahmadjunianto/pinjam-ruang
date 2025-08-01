<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'room_category_id',
        'capacity',
        'location',
        'floor',
        'facilities',
        'image',
        'status',
        'price_per_hour',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'facilities' => 'array',
        'price_per_hour' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the room category that owns the room.
     */
    public function roomCategory()
    {
        return $this->belongsTo(RoomCategory::class);
    }

    /**
     * Get the bookings for the room.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Scope for active rooms.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Check if room is available for specific date and time.
     */
    public function isAvailableAt($date, $startTime, $endTime, $excludeBookingId = null)
    {
        $query = $this->bookings()
            ->where('booking_date', $date)
            ->where('status', '!=', 'rejected')
            ->where('status', '!=', 'cancelled')
            ->where(function ($q) use ($startTime, $endTime) {
                $q->whereBetween('start_time', [$startTime, $endTime])
                  ->orWhereBetween('end_time', [$startTime, $endTime])
                  ->orWhere(function ($q2) use ($startTime, $endTime) {
                      $q2->where('start_time', '<=', $startTime)
                         ->where('end_time', '>=', $endTime);
                  });
            });

        if ($excludeBookingId) {
            $query->where('id', '!=', $excludeBookingId);
        }

        return $query->count() === 0;
    }

    /**
     * Get facilities as formatted string.
     */
    public function getFacilitiesStringAttribute()
    {
        return $this->facilities ? implode(', ', $this->facilities) : '-';
    }
}

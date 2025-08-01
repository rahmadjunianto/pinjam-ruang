<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'room_id',
        'user_id',
        'bidang_id',
        'title',
        'description',
        'contact_person',
        'contact_phone',
        'contact_email',
        'booking_date',
        'start_time',
        'end_time',
        'participants_count',
        'equipment_needed',
        'status',
        'total_cost',
        'approval_notes',
        'approved_at',
        'approved_by',
        'rejection_reason',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'total_cost' => 'decimal:2',
        'approved_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->booking_code)) {
                $booking->booking_code = self::generateBookingCode();
            }
        });
    }

    /**
     * Generate unique booking code.
     */
    public static function generateBookingCode()
    {
        $prefix = 'BK-' . date('Ymd') . '-';
        $lastBooking = self::where('booking_code', 'like', $prefix . '%')
            ->orderBy('booking_code', 'desc')
            ->first();

        if ($lastBooking) {
            $lastNumber = (int) substr($lastBooking->booking_code, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get the room that owns the booking.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Get the user that owns the booking.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the bidang that owns the booking.
     */
    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }

    /**
     * Get the user who approved the booking.
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Scope for pending bookings.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for approved bookings.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope for today's bookings.
     */
    public function scopeToday($query)
    {
        return $query->where('booking_date', Carbon::today());
    }

    /**
     * Scope for upcoming bookings.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('booking_date', '>=', Carbon::today());
    }

    /**
     * Get status badge color.
     */
    public function getStatusBadgeAttribute()
    {
        switch($this->status) {
            case 'pending':
                return 'warning';
            case 'approved':
                return 'success';
            case 'rejected':
                return 'danger';
            case 'completed':
                return 'info';
            case 'cancelled':
                return 'secondary';
            default:
                return 'secondary';
        }
    }

    /**
     * Get duration in hours.
     */
    public function getDurationAttribute()
    {
        $start = Carbon::parse($this->start_time);
        $end = Carbon::parse($this->end_time);
        return $start->diffInHours($end);
    }

    /**
     * Check if booking can be cancelled.
     */
    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'approved']) &&
               $this->booking_date >= Carbon::today();
    }

    /**
     * Check if booking can be edited.
     */
    public function canBeEdited()
    {
        return $this->status === 'pending' &&
               $this->booking_date >= Carbon::today();
    }
}

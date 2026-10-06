<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QueueTicket extends Model
{
    protected $fillable = [
        'ticket_number',
        'daily_sequence',
        'service_id',
        'student_id',
        'kiosk_device_id',
        'status',
        'counter_number',
        'called_by_user_id',
        'issued_at',
        'called_at',
        'served_at',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'daily_sequence' => 'integer',
            'issued_at' => 'datetime',
            'called_at' => 'datetime',
            'served_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function kioskDevice(): BelongsTo
    {
        return $this->belongsTo(KioskDevice::class);
    }

    public function calledByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'called_by_user_id');
    }
}

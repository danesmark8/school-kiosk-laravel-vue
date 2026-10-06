<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicTerm extends Model
{
    protected $fillable = [
        'school_year',
        'semester',
        'is_current',
    ];

    protected function casts(): array
    {
        return [
            'is_current' => 'boolean',
        ];
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn () => "S.Y. {$this->school_year}, {$this->semester}",
        );
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function ledgers(): HasMany
    {
        return $this->hasMany(StudentLedger::class);
    }

    public function paymentTransactions(): HasMany
    {
        return $this->hasMany(PaymentTransaction::class);
    }
}

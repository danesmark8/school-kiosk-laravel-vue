<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    protected $fillable = [
        'code',
        'title',
        'units',
    ];

    protected function casts(): array
    {
        return [
            'units' => 'float',
        ];
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentRegistry extends Model
{
    protected $fillable = ['nim', 'name', 'education_level', 'study_program', 'registration_type'];

    public static function normalizeNim(string $nim): string
    {
        return trim($nim);
    }

    public function pendingRegistrations(): HasMany { return $this->hasMany(PendingRegistration::class); }
    public function tickets(): HasMany { return $this->hasMany(Ticket::class); }
}

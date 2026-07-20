<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'domain',
        'status',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    public function trainingModules()
    {
        return $this->hasMany(TrainingModule::class);
    }

    public function settingsRelation()
    {
        return $this->hasOne(CompanySetting::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    public function getSettingsAttribute()
    {
        return $this->settingsRelation?->settings_json ?? ['timezone' => 'UTC'];
    }
}

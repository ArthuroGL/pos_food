<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'apellido_p',
        'apellido_m',
        'phone',
        'mobile',
        'edad',
        'genero',
        'tipo_sangre',
        'alergias',
        'curp',
        'is_role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getDashboardRoute()
    {
        return match ((int) $this->is_role) {
            2 => url('/admin/dashboard'),
            1 => url('/cocina/dashboard'),
            0 => url('/mesero/dashboard'),
            default => url('/login'),
        };
    }
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->apellido_p} {$this->apellido_m}";
    }
}

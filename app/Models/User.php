<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'region_id',
        'avatar', 'is_active', 'locale',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // public function role(): BelongsTo
    // {
    //     return $this->belongsTo(Role::class);
    // }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function isAdmin(): bool
    {
        return Config::get('fortify.guard') == 'admin'?true : false;
    }

    // public function isModerator(): bool
    // {
    //     return in_array($this->role?->name, ['admin', 'moderator']);
    // }

    // public function hasPermission(string $permission): bool
    // {
    //     return $this->role?->permissions()->where('name', $permission)->exists() ?? false;
    // }

    public function avatarUrl(): string
    {
        return $this->avatar
            ? asset('storage/' . $this->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=2563eb&color=fff';
    }

    // public function assignRole(string $roleName): void
    // {
    //     $role = Role::where('name', $roleName)->first();
    //     if ($role) {
    //         $this->update(['role_id' => $role->id]);
    //     }
    // }

    public function updateProfilePhoto($photo): void
    {
        $path = $photo->store('avatars', 'public');
        $this->update(['avatar' => $path]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'status',
        'rejection_note',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function guru()
    {
        return $this->hasOne(Guru::class);
    }

    public function siswa()
    {
        return $this->hasOne(Siswa::class);
    }

    public function notifikasis()
    {
        return $this->hasMany(Notifikasi::class);
    }

    public function unreadNotifications()
    {
        return $this->notifikasis()->unread();
    }

    public function getUnreadCountAttribute()
    {
        return $this->unreadNotifications()->count();
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }

    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }

    public function isKepalaSekolah(): bool
    {
        return $this->role === 'kepala_sekolah';
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function isInactive(): bool
    {
        return $this->status === 'inactive';
    }

    public function addNotification($title, $message, $type = 'info', $icon = null, $url = null)
    {
        return $this->notifikasis()->create([
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'icon' => $icon,
            'url' => $url,
        ]);
    }

    public function markAllNotificationsAsRead()
    {
        $this->unreadNotifications()->update(['is_read' => true]);
    }

    public function markNotificationAsRead($notificationId)
    {
        $this->notifikasis()->where('id', $notificationId)->update(['is_read' => true]);
    }
}

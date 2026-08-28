<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kebijakan extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'for_role',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForRole($query, $role)
    {
        return $query->where(function ($q) use ($role) {
            $q->where('for_role', 'all')->orWhere('for_role', $role);
        });
    }
}

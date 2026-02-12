<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Auth;

trait HasAccessControl
{
    /**
     * Scope a query to only include items accessible by the given user.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \App\Models\User|null  $user
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForUser($query, $user = null)
    {
        if (!$user) {
            $user = Auth::user();
        }

        if (!$user) {
            // If no user is logged in, assume public access (access_levels is null)
            // or maybe strict deny? The requirement says "ao se logar eu mostraria somente..."
            // implying login is required.
            // If not logged in, maybe show public stuff?
            // Let's assume if not logged in, only show things with null access_levels (public)
            return $query->whereNull('access_levels');
        }

        if (in_array($user->type, ['admin', 'user-adm'])) {
            return $query;
        }

        return $query->where(function ($q) use ($user) {
            $q->whereNull('access_levels')
                ->orWhereJsonContains('access_levels', $user->classification);
        });
    }
}

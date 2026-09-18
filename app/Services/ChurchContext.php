<?php

namespace App\Services;

use App\Models\Church;
use App\Models\User;

class ChurchContext
{
    /**
     * Get the church belonging to the authenticated user.
     */
    public function church(): ?Church
    {
        $user = auth()->user();

        if (!$user instanceof User) {
            return null;
        }

        return $user->church;
    }

    /**
     * Get the current church ID.
     */
    public function id(): ?int
    {
        return $this->church()?->id;
    }

    /**
     * Determine whether a church context exists.
     */
    public function hasChurch(): bool
    {
        return $this->id() !== null;
    }
}
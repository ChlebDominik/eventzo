<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    public function update(User $user, Event $event): bool
    {
        return $user->isOrganizer() && $event->organizer_id === $user->id;
    }

    public function delete(User $user, Event $event): bool
    {
        return $this->update($user, $event);
    }

    public function create(User $user): bool
    {
        return $user->isOrganizer();
    }
}

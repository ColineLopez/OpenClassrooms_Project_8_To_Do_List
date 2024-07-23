<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class TaskVoter extends Voter
{
    // these strings are just invented: you can use anything
    public const VIEW = 'view';
    public const EDIT = 'edit';
    public const DELETE = 'delete';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::VIEW, self::EDIT, self::DELETE])) {
            return false;
        }

        // only vote on `Task` objects
        if (!$subject instanceof Task) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // you know $subject is a Task object, thanks to `supports()`
        /** @var Task $task */
        $task = $subject;

        return match($attribute) {
            self::VIEW => $this->canView($task, $user),
            self::EDIT => $this->canEdit($task, $user),
            self::DELETE => $this->canDelete($task, $user),
            default => throw new \LogicException('This code should not be reached!')
        };
    }

    private function canView(Task $task, User $user): bool
    {
        // if they can edit, they can view
        if ($this->canEdit($task, $user)) {
            return true;
        }

    }

    private function canEdit(Task $task, User $user): bool
    {
        // this assumes that the Task object has a `getUser()` method
        return $user === $task->getUser();
    }

    private function canDelete(Task $task, User $user): bool
    {
        if ($user === $task->getUser()) {
            return true;
        }

        if ($task->getUser() === 'anonymous' && in_array('ROLE_ADMIN', $user->getRoles())) {
            return true;
        }

        return false;
    }
}

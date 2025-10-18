<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class UserVoter extends Voter
{
    public const EDIT = 'edit';
    public const DELETE = 'delete';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::DELETE])
            && $subject instanceof \App\Entity\User;
    }

    protected function voteOnAttribute(string $attribute, mixed $user, TokenInterface $token): bool
    {
        $securityUser = $token->getUser();

        if (!$securityUser instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::EDIT:
                return $securityUser == $user;

            case self::DELETE:
                return $securityUser == $user;
        }

        return false;
    }
}

<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class CharacterVoter extends Voter
{
    public const EDIT = 'EDIT';
    public const DELETE = 'DELETE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::DELETE])
            && $subject instanceof \App\Entity\Character;
    }

    protected function voteOnAttribute(string $attribute, mixed $character, TokenInterface $token): bool
    {
        $securityUser = $token->getUser();

        if (!$securityUser instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::EDIT:
                return $character->getOwner() === $securityUser;

            case self::DELETE:
                return $character->getOwner() === $securityUser;
        }

        return false;
    }
}

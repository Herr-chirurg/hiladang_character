<?php

namespace App\Security\Voter;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class ScenarioVoter extends Voter
{
    private $security;
    public const NEW = 'new';
    public const EDIT = 'edit';
    public const DELETE = 'delete';

    public function __construct(Security $security) {
        $this->security = $security;
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::DELETE, self::NEW])
            && $subject instanceof \App\Entity\Scenario;
    }

    protected function voteOnAttribute(string $attribute, mixed $scenario, TokenInterface $token): bool
    {
        $securityUser = $token->getUser();

        if (!$securityUser instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::NEW:
                return $this->security->isGranted('ROLE_GAMEMASTER');
            case self::EDIT:
                return $securityUser == $scenario->getGameMaster();

            case self::DELETE:
                return $securityUser == $scenario->getGameMaster();
        }

        return false;
    }
}

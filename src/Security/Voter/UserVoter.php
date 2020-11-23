<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVoter extends Voter
{
    CONST LIST = 'user_list';
    CONST EDIT = 'user_edit';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::LIST, self::EDIT])
            && ($subject instanceof User || $subject === null);
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($subject, $user);
            case self::LIST:
                return $this->security->isGranted('ROLE_ADMIN');
                break;
        }

        return false;
    }

    /**
     * @param $subject
     * @param $user
     * @return bool
     */
    private function canEdit($subject, $user): bool
    {
        return ($subject === $user || $this->security->isGranted('ROLE_ADMIN'));
    }
}

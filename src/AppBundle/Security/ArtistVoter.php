<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 08/02/2017
 * Time: 17:04
 */

namespace AppBundle\Security;

use AppBundle\Entity\Artist;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ArtistVoter extends Voter
{
    const VIEW = 'view';
    const EDIT = 'edit';

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::VIEW, self::EDIT])) {
            return false;
        }

        if (!$subject instanceof Artist) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        /** @var Artist $artist */
        $artist = $subject;

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($artist, $user);

        }
    }

    protected function canEdit(Artist $artist, User $user)
    {
        return $artist->getCreatedBy()->getId() === $user->getId();
    }
}

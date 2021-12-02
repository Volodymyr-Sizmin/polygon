<?php

namespace App\Security\Voter;

use App\Entity\Playlist;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class PlaylistVoter extends Voter
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, ['PLAYLIST_CREATE', 'PLAYLIST_EDIT', 'PLAYLIST_DELETE'])
            && $subject instanceof \App\Entity\Playlist;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        /** @var Playlist $playlist */
        $playlist = $subject;

        switch ($attribute) {
            case 'PLAYLIST_CREATE':
                return $this->canCreate($playlist, $user);
            case 'PLAYLIST_EDIT':
                return $this->canEdit($playlist, $user);
            case 'PLAYLIST_DELETE':
                return $this->canDelete($playlist, $user);
        }

        return false;
    }

    private function canCreate(Playlist $playlist, UserInterface $user)
    {
        return $this->security->isGranted('ROLE_USER');
    }

    private function canEdit(Playlist $playlist, UserInterface $user)
    {
        return $user === $playlist->getAuthor();
    }

    private function canDelete(Playlist $playlist, UserInterface $user)
    {
        return $user === $playlist->getAuthor();
    }
}

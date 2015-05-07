<?php
namespace AppBundle\Security\Text;

use AppBundle\Entity\Text\Text;
use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;
use Symfony\Component\Security\Core\User\UserInterface;

final class TextVoter extends AbstractVoter
{
    const VIEW = 'view';

    const VOTE = 'vote';

    const DELETE = 'delete';

    private $entityManager;
    private $container;

    protected function getSupportedAttributes()
    {
        return array(self::VIEW, self::VOTE, self::DELETE);
    }

    protected function getSupportedClasses()
    {
        return array('AppBundle\Entity\Text\Text');
    }

    protected function isGranted($attribute, $text, $user = null)
    {
        if (!$user instanceof UserInterface) {
            return false;
        }

        $em = $this->entityManager;

        if ($attribute === self::VIEW) {
            if (Text::STATUS_NEW === $text->getStatus()) {
                return ($user === $text->getAuthor()->getUser() || in_array('ROLE_ADMIN', $user->getRoles(), true));
            }

            return true;
        }

        if ($attribute === self::DELETE) {
            if (Text::STATUS_NEW === $text->getStatus()) {
                return ($user === $text->getAuthor()->getUser() || in_array('ROLE_ADMIN', $user->getRoles(), true));
            }

            return in_array('ROLE_ADMIN', $user->getRoles(), true);
        }

        if ($attribute === self::VOTE) {
            if (Text::STATUS_VOTING === $text->getStatus()) {
            $hasVoted = $em->getRepository('AppBundle:Vote\IndividualTextVote')->hasVoted($user->getProfile(), $text);

                return !$hasVoted;
            }

            return true;
        }

        return false;
    }

    public function __construct($entityManager, $container)
    {
        $this->entityManager = $entityManager;
        $this->container = $container;
    }
}

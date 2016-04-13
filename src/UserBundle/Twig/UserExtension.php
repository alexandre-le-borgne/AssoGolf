<?php

/**
 * Created by PhpStorm.
 * User: GCC-MED
 * Date: 13/04/2016
 * Time: 16:16
 */
namespace UserBundle\Twig;


use TournamentBundle\Entity\TournamentInscription;
use UserBundle\Entity\User;

class UserExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction("getFinishedTournamentsByUser", array($this, "getFinishedTournamentsByUserFunction"))
        );
    }

    public function getFinishedTournamentsByUserFunction(User $user) {
        $tournaments = array();
        /**
         * @var $inscription TournamentInscription
         */
        foreach ($user->getInscriptions() as $inscription) {
            $tournament = $inscription->getTournament();
            if ($inscription->getValide() && $tournament->getDatetime() < new \Datetime())
                $tournaments[] = $tournament;
        }
        return $tournaments;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return "user_extension";
    }
}
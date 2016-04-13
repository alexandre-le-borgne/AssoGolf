<?php
/**
 * Created by PhpStorm.
 * User: GCC-MED
 * Date: 13/04/2016
 * Time: 11:53
 */

namespace TournamentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TournamentInscription
 *
 * @ORM\Table(name="tournament_inscription")
 * @ORM\Entity(repositoryClass="TournamentBundle\Repository\TournamentInscriptionRepository")
 */
class TournamentInscription
{
    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="tournament", cascade={"persist"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="TournamentBundle\Entity\Tournament", inversedBy="tournament", cascade={"persist"})
     */
    private $tournament;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var boolean
     *
     * @ORM\Column(name="valide", type="boolean", options={"default" = 0})
     */
    private $valide;


    public function __construct()
    {
        $this->valide = false;
    }
    

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set valide
     *
     * @param boolean $valide
     *
     * @return TournamentInscription
     */
    public function setValide($valide)
    {
        $this->valide = $valide;

        return $this;
    }

    /**
     * Get valide
     *
     * @return boolean
     */
    public function getValide()
    {
        return $this->valide;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return TournamentInscription
     */
    public function setUser(\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set tournament
     *
     * @param \TournamentBundle\Entity\Tournament $tournament
     *
     * @return TournamentInscription
     */
    public function setTournament(\TournamentBundle\Entity\Tournament $tournament = null)
    {
        $this->tournament = $tournament;

        return $this;
    }

    /**
     * Get tournament
     *
     * @return \TournamentBundle\Entity\Tournament
     */
    public function getTournament()
    {
        return $this->tournament;
    }
}

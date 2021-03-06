<?php

namespace TournamentBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * Tournament
 *
 * @ORM\Table(name="tournament")
 * @ORM\Entity(repositoryClass="TournamentBundle\Repository\TournamentRepository")
 */
class Tournament
{
    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $organizer;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="TournamentBundle\Entity\TournamentInscription", mappedBy="tournament", cascade={"remove"})
     */
    private $inscriptions;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetime")
     */
    private $datetime;

    /**
     * @var integer
     *
     * @ORM\Column(name="max_players", type="integer")
     */
    private $max_players;


    public function __construct() {
        $this->inscriptions = new ArrayCollection();
    }


   public function isRegistered($user) {
       /**
        * @var $inscription TournamentInscription
        */
       if(!$user) {
           return false;
       }
       foreach ($this->inscriptions as $inscription)
           if($inscription->getValide() && $user == $inscription->getUser())
               return true;
       return false;
   }

    public function isRegistering($user) {
        /**
         * @var $inscription TournamentInscription
         */
        if(!$user) {
            return false;
        }
        foreach ($this->inscriptions as $inscription) {
            if($user == $inscription->getUser())
                return true;
        }
        return false;
    }

    public function getNumberOfValideUsers() {
        $nb = 0;
        foreach ($this->inscriptions as $inscription)
            if($inscription->getValide())
                ++$nb;
        return $nb;
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
     * Set name
     *
     * @param string $name
     *
     * @return Tournament
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set datetime
     *
     * @param \DateTime $datetime
     *
     * @return Tournament
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * Get datetime
     *
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * Set maxPlayers
     *
     * @param integer $maxPlayers
     *
     * @return Tournament
     */
    public function setMaxPlayers($maxPlayers)
    {
        $this->max_players = $maxPlayers;

        return $this;
    }

    /**
     * Get maxPlayers
     *
     * @return integer
     */
    public function getMaxPlayers()
    {
        return $this->max_players;
    }

    /**
     * Set organizer
     *
     * @param \UserBundle\Entity\User $organizer
     *
     * @return Tournament
     */
    public function setOrganizer(\UserBundle\Entity\User $organizer = null)
    {
        $this->organizer = $organizer;

        return $this;
    }

    /**
     * Get organizer
     *
     * @return \UserBundle\Entity\User
     */
    public function getOrganizer()
    {
        return $this->organizer;
    }

    /**
     * Set inscriptions
     *
     * @param \TournamentBundle\Entity\TournamentInscription $inscriptions
     *
     * @return Tournament
     */
    public function setInscriptions(\TournamentBundle\Entity\TournamentInscription $inscriptions = null)
    {
        $this->inscriptions = $inscriptions;

        return $this;
    }

    /**
     * Get inscriptions
     *
     * @return \TournamentBundle\Entity\TournamentInscription
     */
    public function getInscriptions()
    {
        return $this->inscriptions;
    }

    /**
     * Add inscription
     *
     * @param \TournamentBundle\Entity\TournamentInscription $inscription
     *
     * @return Tournament
     */
    public function addInscription(\TournamentBundle\Entity\TournamentInscription $inscription)
    {
        $this->inscriptions[] = $inscription;

        return $this;
    }

    /**
     * Remove inscription
     *
     * @param \TournamentBundle\Entity\TournamentInscription $inscription
     */
    public function removeInscription(\TournamentBundle\Entity\TournamentInscription $inscription)
    {
        $this->inscriptions->removeElement($inscription);
    }
}

<?php

namespace UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\JoinTable;
use FOS\UserBundle\Model\User as BaseUser;
use TournamentBundle\Entity\TournamentInscription;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    const USER = "ROLE_USER";
    const ORGANIZER = "ROLE_ORGANIZER";


    /**
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="TournamentBundle\Entity\TournamentInscription", mappedBy="user", cascade={"remove"})
     */
    private $inscriptions;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="$register_date", type="datetime")
     */
    private $register_date;


    public function __construct() {
        parent::__construct();
        $this->inscriptions = new ArrayCollection();
    }

    public function getValideTournaments() {
        $tournaments = array();
        /**
         * @var $inscription TournamentInscription
         */
        foreach ($this->inscriptions as $inscription) {
            $tournament = $inscription->getTournament();
            if ($inscription->getValide() && $tournament->getDatetime() > new \Datetime())
                $tournaments[] = $tournament;
        }
        return $tournaments;
    }

    public function isGranted($role)
    {
        return in_array($role, $this->getRoles());
    }
    
   

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set registerDate
     *
     * @param \DateTime $registerDate
     *
     * @return User
     */
    public function setRegisterDate($registerDate)
    {
        $this->register_date = $registerDate;

        return $this;
    }

    /**
     * Get registerDate
     *
     * @return \DateTime
     */
    public function getRegisterDate()
    {
        return $this->register_date;
    }

    /**
     * Set inscriptions
     *
     * @param \TournamentBundle\Entity\TournamentInscription $inscriptions
     *
     * @return User
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
     * @return User
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

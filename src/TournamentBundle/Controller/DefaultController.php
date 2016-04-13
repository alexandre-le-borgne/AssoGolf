<?php

namespace TournamentBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use TournamentBundle\Entity\Tournament;
use TournamentBundle\Entity\TournamentInscription;
use UserBundle\Entity\User;
use UserBundle\UserBundle;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $tournaments = $em->getRepository("TournamentBundle:Tournament")->findAll();
        $data = array("tournaments" => $tournaments);
        return $this->render('@Tournament/Default/index.html.twig', $data);
    }

    /**
     * @Route("/nav", name="nav")
     */
    public function navAction()
    {
        $em = $this->getDoctrine()->getManager();
        $tournaments = $em->getRepository("TournamentBundle:Tournament")->findAll();
        $data = array("tournaments" => $tournaments);
        return $this->render('@Tournament/Default/nav.html.twig', $data);
    }

    /**
     * @Route("/tournament/{id}", name="tournament", requirements={"id": "\d+"})
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function tournamentAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $tournament = $em->getRepository("TournamentBundle:Tournament")->find($id);
        if ($tournament == null)
            throw $this->createNotFoundException("Tournoi inconnu");
        return $this->render('@Tournament/Default/tournament.html.twig', array("tournament" => $tournament));
    }

    /**
     * @Route("/tournement/{id}/inscription", name="tournamentInscription", requirements={"id": "\d+"})
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function tournementInscriptionAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        /**
         * @var $user User
         */
        $tournament = $em->getRepository("TournamentBundle:Tournament")->find($id);
        if ($tournament == null)
            throw $this->createNotFoundException("Tournoi inconnu");
        $user = $this->getUser();
        $tournamentInscription = $em->getRepository("TournamentBundle:TournamentInscription")
            ->findBy(array("tournament" => $tournament, "user" => $user));
        if(!$tournamentInscription) {
            $tournamentInscription = new TournamentInscription();
            $em->persist($tournamentInscription->setUser($user)->setTournament($tournament));
            $em->flush();
        }
        return $this->redirectToRoute("tournament", array("id" => $id));
    }

    /**
     * @Route("/tournement/{id}/unscription", name="tournamentUnscription", requirements={"id": "\d+"})
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function tournementUninscriptionAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        /**
         * @var $user User
         */
        $tournament = $em->getRepository("TournamentBundle:Tournament")->find($id);
        if ($tournament == null)
            throw $this->createNotFoundException("Tournoi inconnu");
        $user = $this->getUser();
        $tournamentInscription = $em->getRepository("TournamentBundle:TournamentInscription")
            ->findOneBy(array("tournament" => $tournament, "user" => $user));
        if($tournamentInscription) {
            $em->remove($tournamentInscription);
            $em->flush();
        }
        return $this->redirectToRoute("tournament", array("id" => $id));
    }

    /**
     * @Route("/userTournaments", name="userTournaments")
     */
    public function userTournamentsAction()
    {
        return $this->render('@Tournament/Default/user_tournaments.html.twig');
    }

    /**
     * @Route("/tournamentForm/{id}", name="tournamentForm", requirements={"id": "\d+"})
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function tournamentFormAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $tournament = $em->getRepository("TournamentBundle:Tournament")->find($id);
        if ($tournament == null)
            throw $this->createNotFoundException("Tournoi inconnu");
        return $this->render('tournament_register.html.twig', array("tournament" => $tournament));
    }

    /**
     * @Route("/admin/tournament/users", name="usersTournaments")
     */
    public function usersTournamentsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $tournaments = $em->getRepository("TournamentBundle:Tournament")->findBy(array("organizer" => $this->getUser()));
        return $this->render('@Tournament/Default/tournaments_users.html.twig', array("tournaments" => $tournaments));
    }

    /**
     * @Route("/admin/tournament/new", name="newTournament")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request) {
        $tournament = new Tournament();
        $tournament->setOrganizer($this->getUser());
        $form = $this->createFormBuilder($tournament)
            ->add("name", TextType::class)
            ->add("datetime", DateType::class)
            ->add("max_players", IntegerType::class)
            ->add("save", SubmitType::class, array('label' => "Créer un tournoi"))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database
            $em = $this->getDoctrine()->getManager();
            $em->persist($tournament);
            $em->flush();
            return $this->redirectToRoute('listTournaments');
        }

        return $this->render("@Tournament/Default/new_tournament.html.twig", array("form" => $form->createView()));
    }

    /**
     * @Route("/admin/tournament/{tournament_id}/inscription/{user_id}", name="tournamentInscriptionResponse")
     * @param Request $request
     * @param $tournament_id
     * @param $user_id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function inscriptionAction(Request $request, $tournament_id, $user_id) {
        $em = $this->getDoctrine()->getManager();

        $tournament = $em->getRepository("TournamentBundle:Tournament")->find($tournament_id);
        $user = $em->getRepository("UserBundle:User")->find($user_id);

        if (!$user || !$tournament)
            throw $this->createNotFoundException("Tournoi ou utilisateur inconnu");

        /**
         * @var $tournamentInscription TournamentInscription
         */
        $tournamentInscription = $em->getRepository("TournamentBundle:TournamentInscription")
            ->findOneBy(array("tournament" => $tournament, "user" => $user));

        if($tournamentInscription) {
            if ($request->request->has('accept'))
            {
                $tournamentInscription->setValide(true);
                $em->persist($tournamentInscription);
            }
            elseif ($request->request->has('decline')) {
                $em->remove($tournamentInscription);
            }
            $em->flush();
        }
        return $this->redirectToRoute("usersTournaments");
    }

    /**
     * @Route("/admin/tournaments/", name="listTournaments")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function listTournamentsAction() {
        $em = $this->getDoctrine()->getManager();

        $tournaments = $em->getRepository("TournamentBundle:Tournament")
            ->findBy(array("organizer" => $this->getUser()), array("datetime" => "DESC"));
        
        return $this->render("@Tournament/Default/tournaments.html.twig", array("tournaments" => $tournaments));
    }

    /**
     * @Route("/admin/tournament/edit/{id}", name="tournamentEdit")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $tournament = $em->getRepository("TournamentBundle:Tournament")->find($id);
        
        $form = $this->createFormBuilder($tournament)
            ->add("name", TextType::class)
            ->add("datetime", DateType::class)
            ->add("max_players", IntegerType::class)
            ->add("save", SubmitType::class, array('label' => "Enregistrer les modifications"))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database
            $em = $this->getDoctrine()->getManager();
            $em->persist($tournament);
            $em->flush();
            return $this->redirectToRoute('listTournaments');
        }

        return $this->render("@Tournament/Default/edit_tournament.html.twig", 
            array("tournament" => $tournament, "form" => $form->createView()));
    }

    /**
     * @Route("/admin/tournament/delete/{id}", name="tournamentDelete")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();

        $tournament = $em->getRepository("TournamentBundle:Tournament")->find($id);
        if($tournament) {
            $em->remove($tournament);
            $em->flush();
        }
        return $this->redirectToRoute("listTournaments");
    }
}
<?php

namespace App\Controller;

use App\Manager\UserManager;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Form\Type\UserType;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
  /** @var Serializer */
  private $serializer;

  function __construct()
  {
    $this->serializer = new Serializer(
      [new DateTimeNormalizer(['datetime_format' => 'Y-m-d\TH:i:s.u\Z']), new ObjectNormalizer()],
      ['json' => new JsonEncoder()]
    );
  }

  /**
   * @Route("/users", name="get-users", methods={"GET"})
   *
   * @param UserManager $userManager
   * @return Response
   */
  public function getUsers(UserManager $userManager)
  {
    $users = $userManager->findAllWithDescription();
    return $this->render('users/users.html.twig', ['users' => $users]);

    //return new Response($this->serializer->serialize($users, 'json'));
  }

  /**
   * @Route("/users/{id}", name="get-user", requirements={"id"="\d+"}, methods={"GET"})
   *
   * @param UserManager $userManager
   * @param int $id
   * @return Response
   * @throws Exception
   */
  public function getOneUser(UserManager $userManager, int $id)
  {
    $user = $userManager->findOneWithDescription($id);

    //return new Response($this->serializer->serialize($user, 'json'));


    // Création de notre Form auquel on passe notre objet User.
    $form = $this->createForm(UserType::class, $user);

    // On rajoute le Form au template de la fiche utilisateur pour pouvoir l’afficher.
    return $this->render('users/user.html.twig', ['user' => $user, 'form' => $form->createView()]);
  }

  /**
   * @Route("/users/{id}", name="post-user", requirements={"id"="\d+"}, methods={"POST"})
   *
   * @param UserManager $userManager
   * @param Request $request
   * @param int $id
   * @return Response
   * @throws Exception
   */
  public function postUser(UserManager $userManager, Request $request, int $id)
  {
    $user = $userManager->findOneWithDescription($id);
    $form = $this->createForm(UserType::class, $user);
    $form->handleRequest($request);

    // Si le formulaire est soumis et valide
    if ($form->isSubmitted() && $form->isValid()) {
      // On récupère l’utilisateur dans le formulaire
      /** @var User $user */
      $user = $form->getData();

      // On sauvegarde l’utilisateur
      $em = $this->getDoctrine()->getManager();
      $em->persist($user);
      $em->flush();
    }

    // On redirige sur la fiche utilisateur
    return $this->redirectToRoute('get-user', ['id' => $user->getId()]);
  }
}

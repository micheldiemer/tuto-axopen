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
    return $this->render('users/user.html.twig', ['user' => $user]);
    //return new Response($this->serializer->serialize($user, 'json'));
  }
}

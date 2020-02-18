<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BeautySalon;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends Controller
{
    /**
     * @Route("/account/update/{username}", name="user_update")
     */
    public function updateUserAction($username, Request $request)
    {

        $user = $this->getDoctrine()->getManager()->getRepository("AppBundle:User")
            ->findOneBy(array('username' => $username));

        if(!$user){
            return new JsonResponse([
                'message' => 'Username doesnt exists',
                'status' => Response::HTTP_UNAUTHORIZED
            ]);
        }

        $data = json_decode($request->getContent(), true);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        $response = new JsonResponse($data, 200);

        return $response;
//        return new Response(
//            'Welcome '. $user->getUsername(),
//            Response::HTTP_OK
//        );
    }
}


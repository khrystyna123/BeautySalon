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

        if ($request->query->has('username')) {
            $user->setUsername($request->get('username'));
        }
        if ($request->query->has('email')) {
            $user->setEmail($request->get('email'));
        }
        if ($request->query->has('password')) {
            $user->setPassword($request->get('password'));
        }
        if ($request->query->has('role_id')) {
            $user->setRole($request->get('role_id'));
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return new Response(
            'Welcome '. $user->getUsername(),
            Response::HTTP_OK
        );
    }
}


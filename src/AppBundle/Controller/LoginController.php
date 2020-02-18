<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Controller\AccountController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends Controller
{
    /**
     * @Route("/login", name="user_login")
     */
    public function loginAction(Request $request)
    {
        $_username = $request->get('username');
        $_password = $request->get('password');

        $factory = $this->get('security.encoder_factory');

        $user = $this->getDoctrine()->getManager()->getRepository("AppBundle:User")
                ->findOneBy(array('username' => $_username));

        if(!$user){
            return new JsonResponse([
                'message' => 'Username doesnt exists',
                'status' => Response::HTTP_UNAUTHORIZED
            ]);
        }

        $encoder = $factory->getEncoder($user);
        $salt = $user->getSalt();

        if(!$encoder->isPasswordValid($user->getPassword(), $_password, $salt)) {
            return new JsonResponse([
                'message' => 'Username or Password not valid',
                'status' => Response::HTTP_UNAUTHORIZED
            ]);
        } 

        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->get('security.token_storage')->setToken($token);

        $this->get('session')->set('_security_main', serialize($token));

        $event = new InteractiveLoginEvent($request, $token);
        $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);

        return new JsonResponse([
            'message' => 'Welcome '. $user->getUsername(),
            'status' => Response::HTTP_OK
        ]);
    }
}
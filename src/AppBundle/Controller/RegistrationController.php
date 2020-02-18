<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Address;
use AppBundle\Entity\BeautySalon;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends Controller
{
    const OWNER = 2;

    /**
     * @Route("/register", name="user_registration")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();

        $user->setUsername($request->get('username'));
        $user->setEmail($request->get('email'));
        $password = $passwordEncoder->encodePassword($user, $request->get('password'));
        $user->setPassword($password);
        $user->setRole($request->get('role_id'));

        $validator = $this->get('validator');
        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;

            return new Response($errorsString);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        $response = new JsonResponse(['username' => $user->getUsername(), 
                                        'message' => 'Registered succesfully!']);

        return $response;
    }

    /**
     * @Route("/register/salon/{username}", name="salon_registration")
     */
    public function registerSalonAction($username, Request $request)
    {
        $owner = $this->getDoctrine()->getManager()->getRepository("AppBundle:User")
            ->findOneBy(array('username' => $username));

        if ($owner->getRole() != self::OWNER) {
            return new JsonResponse([
                'message' => 'You are not salon owner',
                'status' => Response::HTTP_FORBIDDEN
            ]);
        }

        $salon = new BeautySalon();
        $address = new Address();

        $salon->setName($request->get('name'));
        $salon->setInstaUsername($request->get('insta_username'));
        $address->setCity($request->get('city'));
        $address->setStreet($request->get('street'));
        $address->setHouseNumber($request->get('house_number'));

        $salon->setOwner($owner);
        $address->setSalon($salon);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($salon);
        $entityManager->persist($owner);
        $entityManager->persist($address);
        $entityManager->flush();

        $response = new JsonResponse(['name' => $salon->getName(),
                                        'owner' => $owner->getUsername(),
                                        'message' => 'Registered succesfully!']);

        return $response;
    }
}


<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BeautySalon;
use AppBundle\Entity\User;
use AppBundle\Entity\Address;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SalonController extends Controller
{
    /**
     * @Route("/account/{salonname}/address", name="user_update")
     */
    public function addAddressAction($salonname, Request $request)
    {

        $salon = $this->getDoctrine()->getManager()->getRepository("AppBundle:BeautySalon")
            ->findOneBy(array('name' => $salonname));

        if(!$salon){
            return new JsonResponse([
                'message' => 'Salon doesnt exists',
                'status' => Response::HTTP_UNAUTHORIZED
            ]);
        }

        $address = new Address();

        $address->setCity($request->get('city'));
        $address->setStreet($request->get('street'));
        $address->setHouseNumber($request->get('house_number'));

        $address->setSalon($salon);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($salon);
        $entityManager->flush();

        return new Response(
            Response::HTTP_OK
        );
    }
}
<?php

namespace AppBundle\Controller;

use AppBundle\Enums\OpeningStatus;
use AppBundle\Enums\Days;
use AppBundle\Entity\BeautySalon;
use AppBundle\Entity\SalonInformation;
use AppBundle\Entity\Schedule;
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
     * @Route("/account/{salonname}/address", name="address_add")
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
        $salon->setAddress($address);


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($salon);
        $entityManager->persist($address);
        $entityManager->flush();

        return new Response(
            Response::HTTP_OK
        );
    }

    /**
     * @Route("/account/{salonname}/info", name="info_add")
     */
    public function addInfoAction($salonname, Request $request, FileUploader $fileUploader)
    {

        $salon = $this->getDoctrine()->getManager()->getRepository("AppBundle:BeautySalon")
            ->findOneBy(array('name' => $salonname));

        if(!$salon){
            return new JsonResponse([
                'message' => 'Salon doesnt exists',
                'status' => Response::HTTP_UNAUTHORIZED
            ]);
        }

        $info = new SalonInformation();

        $logoFile = $request->files->get("logo");
        $logoFileName = $fileUploader->upload($logoFile);
        $info->setLogo($logoFileName);

        $info->setInfo($request->get("info"));
        $info->setEmail($request->get("email"));
        $info->setPhoneNumber($request->get("number"));

        $info->setSalon($salon);
        $salon->setInfo($info);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($salon);
        $entityManager->persist($info);
        $entityManager->flush();

        return new Response(
            Response::HTTP_OK
        );
    }

    /**
     * @Route("/account/{salonname}/schedule", name="schedule_add")
     */
    public function addScheduleAction($salonname, Request $request)
    {

        $salon = $this->getDoctrine()->getManager()->getRepository("AppBundle:BeautySalon")
            ->findOneBy(array('name' => $salonname));

        if(!$salon){
            return new JsonResponse([
                'message' => 'Salon doesnt exists',
                'status' => Response::HTTP_UNAUTHORIZED
            ]);
        }

        $days = array(Days::Monday, Days::Tuesday, Days::Wednesday, Days::Thursday, Days::Friday,
            Days::Saturday, Days::Sunday);

        foreach ($days as $day) {
            $schedule = new Schedule();

            $schedule->setDay($day);
            $schedule->setStatus($request->get("status" . $day));
            if ($schedule->getStatus() == OpeningStatus::Opened) {
                $schedule->setStartTime($request->get("start_time" . $day));
                $schedule->setEndTime($request->get("end_time" . $day));
            }

            $schedule->setSalon($salon);
            $salon->setSchedule($schedule);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($salon);
            $entityManager->persist($schedule);
            $entityManager->flush();
        }

        return new Response(
            Response::HTTP_OK
        );
    }

}
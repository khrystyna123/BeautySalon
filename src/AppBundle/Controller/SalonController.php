<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BeautySalon;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SalonController extends Controller
{
    /**
     * @Route("/{name}", name="salon_instagram")
     */
    public function instagramAction($name)
    {
        $salon = $this->getDoctrine()->getManager()->getRepository("AppBundle:BeautySalon")
                ->findOneBy(array('name' => $name));

        $username = $salon->getInstaUsername();

//        $json = file_get_contents('https://www.instagram.com/'.$username.'/media/');
//        $instagram_feed_data = json_decode($json, true);

//        $instaResult = file_get_contents('https://www.instagram.com/'.$username.'/?__a=1');
//        $insta = json_decode($instaResult);
//        $instagram_photos = $insta->graphql->user->edge_owner_to_timeline_media->edges;

        

        return new Response (
        Response::HTTP_OK
        );
    }
}
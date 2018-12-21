<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Service\MessageGenerator;

class LuckyController extends Controller
{

    public function number()
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }

    /**
     * @Route("/api/lucky/number")
     */
    public function apiNumberAction()
    {
        $data = array(
            'lucky_number' => rand(0, 100),
        );

        // calls json_encode and sets the Content-Type header
        return new JsonResponse($data);
    }

    /**
     * @Route("/lucky/number/{count}")
     */
    public function numberAction($count)
    {
        $numbers = array();
        for ($i = 0; $i < $count; $i++) {
            $numbers[] = rand(0, 100);
        }
        $numbersList = implode(', ', $numbers);

        /*
        $html = $this->container->get('templating')->render(
            'lucky/number.html.twig',
            array('luckyNumberList' => $numbersList)
        );

        return new Response($html);
        */

        // render: a shortcut that does the same as above
        return $this->render(
            'lucky/number.html.twig',
            array('luckyNumberList' => $numbersList)
        );
    }

    /**
     * @Route("/happy/message")
     */
    public function new(MessageGenerator $messageGenerator)
    {
        // thanks to the type-hint, the container will instantiate a
        // new MessageGenerator and pass it to you!
        // ...

        $message = $messageGenerator->getHappyMessage();
        return $this->render(
            'lucky/happyMessage.html.twig',
            array('happyMessage' => $message)
        );
    }

    /**
     * @Route("/hello/{name}", name="hello")
    */
    public function indexAction($name)
    {
        return new Response('<html><body>Hello '.$name.'!</body></html>');
    }
}

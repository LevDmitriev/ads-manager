<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class YouRentaController extends AbstractController
{

    /**
     * @Route("/you-renta", name="you_renta")
     */
    public function index()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $client->request('GET', 'https://yourenta.ru/login.html');
        $client->submitForm('#login-form', ['enter_email' => 'gfdh6@mail.ru', 'enter_pass' => 444444]);
        // Wait for an element to be rendered
        $crawler = $client->getCrawler();
        return new Response($crawler->filter('#l1')->text(), 200);
    }
}

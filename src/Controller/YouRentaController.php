<?php

namespace App\Controller;

use App\Entity\YouRenta\YouRentaAdvertisement;
use App\Entity\YouRenta\YouRentaUser;
use App\HttpClients\YouRentaClient;
use Facebook\WebDriver\WebDriverBy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Panther\Client;
use Symfony\Component\Routing\Annotation\Route;

class YouRentaController extends AbstractController
{
    /**
     * @var YouRentaClient Http клиент для работы с yourenta
     */
    private $client;

    public function __construct(YouRentaClient $client) {
        $this->client = $client;
    }

}

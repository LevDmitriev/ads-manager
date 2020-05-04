<?php

namespace App\Controller;

use App\Entity\YouRenta\YouRentaAdvertisement;
use App\Entity\YouRenta\YouRentaUser;
use Facebook\WebDriver\WebDriverBy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Panther\Client;
use Symfony\Component\Routing\Annotation\Route;

class YouRentaController extends AbstractController
{
    /**
     * @var Client Http клиент для работы с yourenta
     */
    private $client;

    public function __construct() {
        $this->client = Client::createChromeClient(null, null, [],'https://yourenta.ru');
    }

    /**
     * @Route("/you-renta/update/{id}", name="you_renta_update")
     * @param YouRentaAdvertisement $advertisement Объявление, которое нужно обновить
     */
    public function updateAdvertisement(YouRentaAdvertisement $advertisement)
    {

    }

    /**
     * Получить клиента для работы с текущей страницей
     * @return Client
     */
    public function getClient() : Client
    {
        return $this->client;
    }

    /**
     * @param YouRentaAdvertisement $advertisement Подать объявление
     *
     * @return Response
     */
    public function addAdvertisement(YouRentaAdvertisement $advertisement)
    {
        $this->client->request('GET', '/add-flat.html');
        return new Response($this->client->getCrawler()->text());
    }

    /**
     * Перейти на страницу списка объявлений.
     * @see \App\Tests\Controller\YouRentaControllerTest::testToAdvertisementsList unit test
     * @return $this
     */
    public function toAdvertisementsList(): self
    {
        $this->client->request('GET', '/user-index.html');

        return $this;
    }

    /**
     * Авторизоваться
     * @param YouRentaUser $user Пользователь, под которым необходимо авторизоваться
     *
     * @see \App\Tests\Controller\YouRentaControllerTest::testAuthorize unit test
     */
    public function authorize(YouRentaUser $user)
    {
        $this->client->request('GET', '/login.html');
        $crawler = $this->client->getCrawler();
        $crawler->filter('#login-form')->form(['enter_email' => $user->getLogin(), 'enter_pass' => $user->getPassword()]);
        $crawler->filter('#uniform-enter')->first()->click();
        $this->client->waitFor('#cabinetcontent');

        return $this;
    }
}

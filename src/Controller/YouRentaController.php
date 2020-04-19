<?php

namespace App\Controller;

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
     * @Route("/you-renta", name="you_renta")
     */
    public function addAdvertisements()
    {
        $this->authorize('gfdh6@mail.ru', 444444);
        $this->client->request('GET', '/add-flat.html');
        return new Response($this->client->getCrawler()->text());
    }

    /**
     * Авторизоваться
     * @param string $login Логин
     * @param string $password Пароль
     *
     * @see \App\Tests\YouRentaControllerTest::testAuthorize unit test
     *
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     * @throws \Facebook\WebDriver\Exception\TimeoutException
     */
    private function authorize(string $login, string $password)
    {
        $this->client->request('GET', '/login.html');
        $crawler = $this->client->getCrawler();
        $crawler->filter('#login-form')->form(['enter_email' => $login, 'enter_pass' => $password]);
        $crawler->filter('#uniform-enter')->first()->click();
        $this->client->waitFor('#cabinetcontent');
    }

    /**
     * Заполнить форму добавления объявления
     */
    private function fillAddForm($data) {
        $crawler = $this->client->getCrawler();
    }
}

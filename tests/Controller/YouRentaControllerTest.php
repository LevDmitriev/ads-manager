<?php

namespace App\Tests;

use App\Controller\YouRentaController;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Panther\PantherTestCase;

/**
 * @coversDefaultClass \App\Controller\YouRentaController
 */
class YouRentaControllerTest extends PantherTestCase
{
    private $client;
    private $login;
    private $password;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createPantherClient(['external_base_uri' => 'https://yourenta.ru']);
        $this->login = 'gfdh6@mail.ru';
        $this->password = 444444;
    }

    /**
     * Тест авторизации
     * @covers ::authorize
     */
    public function testAuthorize()
    {
        $this->client->request('GET', '/login.html');
        $crawler = $this->client->getCrawler();
        $crawler->filter('#login-form')->form(['enter_email' => $this->login, 'enter_pass' => $this->password]);
        $crawler->filter('#uniform-enter')->first()->click();
        $this->client->waitFor('#cabinetcontent');
        $this->assertEquals(
            1,
            $this->client->getCrawler()->filter('#cabinetcontent')->count(),
            'Не авторизуется'
        );
    }

    /**
     * Авторизоваться
     */
    public function authorize()
    {
        $this->client->request('GET', '/login.html');
        $crawler = $this->client->getCrawler();
        $crawler->filter('#login-form')->form(['enter_email' => $this->login, 'enter_pass' => $this->password]);
        $crawler->filter('#uniform-enter')->first()->click();
        $this->client->waitFor('#cabinetcontent');
    }

    public function testFillAddForm()
    {
        $this->authorize();
        $this->client->request('GET', '/add-flat.html');
        $crawler = $this->client->getCrawler();
        $crawler->filter('form[action="//yourenta.ru/user-add-flat.html"]')->form($this->getAddFormData());
    }

    private function getAddFormData(): array
    {
        return [
            'object_f' => 1,
            'rayon_f' => 3,
            'adres_f' => 'Победы',
            'home_f' => 35,
            'rooms' => 1,
            'price_d' => 800,
            'price_h' => 150,
            'guest' => 2,
            'etag' => 0,
            'etag_all' => 3,
            'phone_1' => '+7-963-918-74-59',
            'inet' => 'ON',
            'sm' => 'ON',
            'parkovka_f' => 'ON',
            'dop' => "Прекрасная современная квартира в самом центре города для комфортного времяпровождения.
            Удобное месторасположение до любой точки города. В шаговой доступности расположены главная площадь города,
            рестораны различной ценовой категории, кинотеатры, супермаркеты и т. д. Удобная двухспальная кровать.
            Всегда свежее постельное белье и чистые полотенца. Горячая вода круглосуточно.
            Квартира предназначена исключительно для проживания!  Уборка и смена белья после каждого клиента.",
        ];
    }
}

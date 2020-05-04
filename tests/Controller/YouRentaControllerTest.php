<?php

namespace App\Tests\Controller;

use App\Controller\YouRentaController;
use App\Entity\YouRenta\YouRentaAdvertisement;
use App\Entity\YouRenta\YouRentaUser;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverElement;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Controller\YouRentaController
 */
class YouRentaControllerTest extends TestCase
{
    /** @var YouRentaController Контроллер YouRenta */
   private $controller;
   /** @var Generator */
   private $faker;

    protected function setUp() : void
    {
        parent::setUp();
        $this->controller = new YouRentaController();
        $this->faker = Factory::create();
    }

    /**
     * @covers ::addAdvertisement
     */
    public function testAddAdvertisement(YouRentaAdvertisement $advertisement)
    {
        $this->controller
            ->authorize($advertisement->getUser())
            ->addAdvertisement($advertisement)
        ;
    }

    /**
     * @dataProvider userDataProvider
     *
     * @param YouRentaUser $user Пользователь, под которым должна идти авторизация
     */
    public function testToAdvertisementsList(YouRentaUser $user)
    {
        $this->controller->authorize($user)->toAdvertisementsList();
        $crowler = $this->controller->getClient()->getCrawler();
        $this->assertInstanceOf(WebDriverElement::class,  $crowler->findElement(WebDriverBy::className('mainflat')));
    }

    /**
     * @dataProvider userDataProvider
     *
     * @param YouRentaUser $user Пользователь, под которым нужно авторизоваться
     * @covers ::authorize
     */
    public function testAuthorize(YouRentaUser $user)
    {
        $this->controller->authorize($user);
        $crowler = $this->controller->getClient()->getCrawler();
        $this->assertInstanceOf(WebDriverElement::class,  $crowler->findElement(WebDriverBy::id('cabinetcontent')));
    }

    /**
     * Провайдер пользователей
     * @return YouRentaUser[]
     */
    public function userDataProvider()
    {
        $user = new YouRentaUser();
        $user->setLogin('gfdh6@mail.ru');
        $user->setPassword(444444);

        return ['common_user' => [$user]];
    }
}

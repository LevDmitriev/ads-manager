<?php

namespace App\Tests\HttpClients;

use App\Entity\YouRenta\YouRentaAdvertisement;
use App\Entity\YouRenta\YouRentaAdvertisementPhoto;
use App\Entity\YouRenta\YouRentaCityDistrict;
use App\Entity\YouRenta\YouRentaGuestCount;
use App\Entity\YouRenta\YouRentaObjectType;
use App\Entity\YouRenta\YouRentaUser;
use App\HttpClients\YouRentaClient;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverElement;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\HttpClients\YouRentaClient
 */
class YouRentaClientTest extends TestCase
{
    private $client;
    public function setUp(): void
    {
        $this->client = new YouRentaClient();
    }

    /**
     * @dataProvider userDataProvider
     *
     * @param YouRentaUser $user Пользователь, под которым нужно авторизоваться
     * @covers ::authorize
     */
    public function testAuthorize(YouRentaUser $user)
    {
        $crowler = $this->client->authorize($user)->getClient()->getCrawler();
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

        return [[$user]];
    }

    /**
     * @covers ::addAdvertisement
     * @param YouRentaAdvertisement $advertisement
     */
    public function testAddAdvertisement(YouRentaAdvertisement $advertisement)
    {
        $crawler = $this->client->addAdvertisement($advertisement)->getClient()->getCrawler();
        /** @var WebDriverElement $element */
        $element = $crawler->findElement(
            WebDriverBy::partialLinkText(
                implode(',', [$advertisement->getStreet(), $advertisement->getBuildingNumber()])
            )
        );

        $this->assertInstanceOf(WebDriverElement::class,  $element);
    }

    /**
     * @dataProvider advertisementDataProvider
     * @covers ::deleteAdvertisement
     * @param YouRentaAdvertisement $advertisement
     */
    public function testDeleteAdvertisement(YouRentaAdvertisement $advertisement)
    {
        $this->client->deleteAdvertisement($advertisement)->getClient()->getCrawler();
    }

    /**
     * Провайдер объявлений
     */
    public function advertisementDataProvider()
    {
        $user = $this->userDataProvider()[0][0];
        $faker = Factory::create();
        $floor = $faker->randomNumber(1);
        $advertisement = new YouRentaAdvertisement();
        $advertisement->setUser($user);
        $advertisement->setDescription($faker->text);
        $advertisement->setBuildingNumber($faker->buildingNumber);
        $advertisement->setConditioner($faker->boolean());
        $advertisement->setParking($faker->boolean());
        $advertisement->setWasher($faker->boolean());
        $advertisement->setInternet($faker->boolean());
        $advertisement->setStreet($faker->streetName);
        $advertisement->setRentConditions($faker->text());
        $advertisement->setRentConditionsWedding($faker->text);
        $advertisement->setFloor($floor);
        $advertisement->setFloorsCount($floor + 1);
        $advertisement->setFirstPhone($faker->phoneNumber);
        $advertisement->setSecondPhone($faker->phoneNumber);
        $advertisement->setPriceDay($faker->numberBetween(1000, 1500));
        $advertisement->setPriceNight($faker->numberBetween(1000, 1500));
        $advertisement->setPriceHour($faker->numberBetween(500, 600));
        $advertisement->setPriceWedding($faker->numberBetween(1500, 2000));
        $advertisement->setRoomsNumber($faker->numberBetween(1, 3));
        $advertisement->setTotalArea($advertisement->getRoomsNumber() * 20);
        $advertisement->setYouTube($faker->url);

        $district = $this->getMockBuilder(YouRentaCityDistrict::class)->setMethods(['getValue'])->getMock();
        $district->method('getValue')->willReturn($faker->numberBetween(1, 3));

        $advertisement->setDistrict($district);

        $guestCount = $this->getMockBuilder(YouRentaGuestCount::class)->setMethods(['getValue'])->getMock();
        $guestCount->method('getValue')->willReturn($faker->numberBetween(1, 11));
        $advertisement->setGuestCount($guestCount);

        $photo = $this->getMockBuilder(YouRentaAdvertisementPhoto::class)->setMethods(['getImage'])->getMock();
        $photo->method('getImage')->willReturn($faker->imageUrl());
        $advertisement->addPhoto($photo);

        $objectType = $this->getMockBuilder(YouRentaObjectType::class)->setMethods(['getValue'])->getMock();
        $objectType->method('getValue')->willReturn($faker->numberBetween(1, 2));
        $advertisement->setObjectType($objectType);

        return [[$advertisement]];
    }
}
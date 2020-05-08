<?php

namespace App\Tests\HttpClients;

use App\Entity\YouRenta\YouRentaAdvertisement;
use App\Entity\YouRenta\YouRentaAdvertisementPhoto;
use App\Entity\YouRenta\YouRentaCityDistrict;
use App\Entity\YouRenta\YouRentaGuestCount;
use App\Entity\YouRenta\YouRentaObjectType;
use App\Entity\YouRenta\YouRentaUser;
use App\HttpClients\YouRentaClient;
use Doctrine\Common\Collections\ArrayCollection;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverElement;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Panther\DomCrawler\Crawler;
use Vich\UploaderBundle\Mapping\PropertyMappingFactory;
use Vich\UploaderBundle\Storage\FileSystemStorage;
use Vich\UploaderBundle\Storage\StorageInterface;

/**
 * @coversDefaultClass \App\HttpClients\YouRentaClient
 */
class YouRentaClientTest extends KernelTestCase
{

    private $client;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        if (!static::$booted) {
            static::bootKernel();
        }
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->client = self::$container->get(YouRentaClient::class);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->client->getClient()->quit();
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
     * @dataProvider advertisementDataProvider
     * @covers ::deleteAdvertisement
     * @covers ::addAdvertisement
     * @param YouRentaAdvertisement $advertisement
     */
    public function testAddAndDeleteAdvertisement(YouRentaAdvertisement $advertisement)
    {
        $text = Crawler::xpathLiteral(implode(', ', [$advertisement->getStreet(), $advertisement->getBuildingNumber()]));
        $crawlerAfterAdd = $this->client
            ->authorize($advertisement->getUser())
            ->addAdvertisement($advertisement)
            ->getClient()
            ->getCrawler()
            ->filterXPath(
                "descendant::a[contains(string(.), $text)]/./ancestor::div[contains(@class, 'rd')]/descendant::a[contains(string(.), 'удалить')]"
            )
        ;
        $this->assertCount(1, $crawlerAfterAdd);
        $crawlerAfterDelete = $this->client
            ->deleteAdvertisement($advertisement)
            ->getClient()
            ->getCrawler()
            ->filterXPath(
                "descendant::a[contains(string(.), $text)]/./ancestor::div[contains(@class, 'rd')]/descendant::a[contains(string(.), 'удалить')]"
            )
            ;
        $this->assertCount(0, $crawlerAfterDelete);
    }

    /**
     * Тест на добавление и удаление множества объявлений
     * @param ArrayCollection<YouRentaAdvertisement>  $advertisements
     * @dataProvider advertisementCollectionDataProvider
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     * @throws \Facebook\WebDriver\Exception\TimeoutException
     */
    public function testAddAndDeleteMultipleAdvertisements(ArrayCollection $advertisements)
    {
        $this->client->authorize($advertisements->first()->getUser());
        /** @var YouRentaAdvertisement $advertisement */
        foreach ($advertisements as $advertisement) {
            $crawlerAfterAdd = $this->client
                ->addAdvertisement($advertisement)
                ->getClient()
                ->getCrawler()
                ->filterXPath($this->client->getXpathAdvertisementInList($advertisement))
            ;
            $this->assertCount(1, $crawlerAfterAdd);
        }

        foreach ($advertisements as $advertisement) {
            $crawlerAfterAdd = $this->client
                ->deleteAdvertisement($advertisement)
                ->getClient()
                ->getCrawler()
                ->filterXPath($this->client->getXpathAdvertisementInList($advertisement))
            ;
            $this->assertCount(0, $crawlerAfterAdd);
        }
    }

    /**
     * Провайдер объявлений
     */
    public function advertisementDataProvider()
    {
        if (!static::$booted) {
            static::bootKernel();
        }
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
        /** @var YouRentaAdvertisementPhoto $photo */
        $photo = new YouRentaAdvertisementPhoto();
        $photo->setImage( __METHOD__ . '.jpg');
        /** @var PropertyMappingFactory */
        $mappingFactory = self::$container->get(PropertyMappingFactory::class);
        $mapping = $mappingFactory->fromField($photo, 'imageFile');
        /** @var FileSystemStorage $storage */
        $storage = self::$container->get(StorageInterface::class);
        $photo->setImageFile(new File($storage->resolvePath($photo, 'imageFile') . '/' . $photo->getImage(), false));

        // Загружаем изображение
        if (!file_exists($photo->getImageFile()->getPath())) {
            copy($faker->imageUrl(), $photo->getImageFile()->getPath());
        }
        $advertisement->addPhoto($photo);
        $advertisement->addPhoto(clone $photo);
        $advertisement->addPhoto(clone $photo);
        $advertisement->addPhoto(clone $photo);
        $advertisement->addPhoto(clone $photo);

        $objectType = $this->getMockBuilder(YouRentaObjectType::class)->setMethods(['getValue'])->getMock();
        $objectType->method('getValue')->willReturn($faker->numberBetween(1, 2));
        $advertisement->setObjectType($objectType);

        return [[$advertisement]];
    }

    /**
     * Провайдер коллекции объявлений
     */
    public function advertisementCollectionDataProvider()
    {
        $collection = new ArrayCollection();
        for ($i = 0; $i < 3; $i++) {
            $collection->add($this->advertisementDataProvider()[0][0]);
        }

        return [[$collection]];
    }
}
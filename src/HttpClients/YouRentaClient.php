<?php

namespace App\HttpClients;

use App\Entity\YouRenta\YouRentaAdvertisement;
use App\Entity\YouRenta\YouRentaUser;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use PharIo\Manifest\InvalidUrlException;
use Symfony\Component\Panther\Client;
use Symfony\Component\Panther\DomCrawler\Crawler;
use Symfony\Component\Panther\DomCrawler\Form;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Клиент для работы с сайтом YouRenta
 */
class YouRentaClient
{
    /** @var string URL списка объявлений пользователя */
    public const URL_ADVERTISEMENT_LIST = 'user-index.html';

    private $client;
    public function __construct()
    {
        $this->client = Client::createChromeClient(null, null, [],'https://yourenta.ru');
    }

    /**
     * Получить клиент
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * Авторизоваться
     * @param YouRentaUser $user Пользователь, под которым необходимо авторизоваться
     *
     * @see \App\Tests\HttpClients\YouRentaClientTest::testAuthorize unit test
     */
    public function authorize(YouRentaUser $user): self
    {
        $crawler = $this->client->get('/login.html')->getCrawler();
        $crawler->filter('#login-form')->form(['enter_email' => $user->getLogin(), 'enter_pass' => $user->getPassword()]);
        $crawler->filter('#uniform-enter')->first()->click();
        $this->client->waitFor('#cabinetcontent');

        return $this;
    }

    /**
     * Добавить объявление
     *
     * @param YouRentaAdvertisement $advertisement Объявление, которое следует добавить
     *
     * @return YouRentaClient
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     * @throws \Facebook\WebDriver\Exception\TimeoutException
     * @see \App\Tests\HttpClients\YouRentaClientTest::testAddAndDeleteAdvertisement unit test
     */
    public function addAdvertisement(YouRentaAdvertisement $advertisement): self
    {
        $crawler = $this->client->get('/add-flat.html')->getCrawler();
        /** @var Form $form Форма добавления объявления */
        $form = $crawler->filter('form[action="//yourenta.ru/user-add-flat.html"]')->form();
        $form->setValues([
                             'object_f' => $advertisement->getObjectType()->getValue(),
                             'rayon_f' => $advertisement->getDistrict()->getValue(),
                             'adres_f' => $advertisement->getStreet(),
                             'home_f' => $advertisement->getBuildingNumber(),
                             'rooms' => $advertisement->getRoomsNumber(),
                             'price_d' => $advertisement->getPriceDay(),
                             'price_h' => $advertisement->getPriceHour(),
                             'price_n' => $advertisement->getPriceNight(),
                             'price_svadba' => $advertisement->getPriceWedding(),
                             'guest' => $advertisement->getGuestCount()->getValue(),
                             'etag' => $advertisement->getFloor(),
                             'etag_all' => $advertisement->getFloorsCount(),
                             'phone_1' => $advertisement->getFirstPhone(),
                             'phone_2' => $advertisement->getSecondPhone(),
                         ]);
        $crawler->findElement(WebDriverBy::cssSelector('a[href="#tabs-2"]'))->click();
        $form->get('inet')->setValue($advertisement->getInternet());
        $form->get('sm')->setValue($advertisement->getWasher());
        $form->get('parkovka_f')->setValue($advertisement->getParking());
        $form->get('conditioner_f')->setValue($advertisement->getConditioner());
        $form->get('dop')->setValue($advertisement->getDescription());
        $form->get('uslov')->setValue($advertisement->getRentConditions());
        $form->get('uslov_svadba')->setValue($advertisement->getRentConditionsWedding());
        $crawler->findElement(WebDriverBy::cssSelector('a[href="#tabs-3"]'))->click();
        foreach ($advertisement->getPhotos() as $key => $photo) {
            $form->get('img' . ($key + 1))->upload($photo->getImage());
        }
        $this->client->submit($form);
        $this->getClient()->wait()->until(
            WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::id('fancybox-close'))
        );
        $this->getClient()->findElement(WebDriverBy::id('fancybox-close'))->click();

        return $this;
    }

    /**
     * Удалить объявление с сайта
     *
     * @param YouRentaAdvertisement $advertisement Объявление
     * @see \App\Tests\HttpClients\YouRentaClientTest::testAddAndDeleteAdvertisement unit test
     *
     * @return YouRentaClient
     */
    public function deleteAdvertisement(YouRentaAdvertisement $advertisement): self
    {
        if (strpos($this->getClient()->getCurrentURL(), self::URL_ADVERTISEMENT_LIST) < 0) {
            throw new InvalidUrlException('current url must contain' . self::URL_ADVERTISEMENT_LIST);
        }
        $text = Crawler::xpathLiteral(implode(', ', [$advertisement->getStreet(), $advertisement->getBuildingNumber()]));
        /** @var Crawler Парсер блока редактирования бъявления */
        $crawler = $this
            ->getClient()
            ->getCrawler()
            ->filterXPath(
                "descendant::a[contains(string(.), $text)]/./ancestor::div[contains(@class, 'rd')]/descendant::a[contains(string(.), 'удалить')]"
            )
        ;
        $crawler->first()->click();
        $this->getClient()->getWebDriver()->switchTo()->alert()->accept();
        $this->getClient()->wait()->until(
            WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::id('fancybox-close'))
        );
        $this->getClient()->findElement(WebDriverBy::id('fancybox-close'))->click();

        return $this;
    }
}
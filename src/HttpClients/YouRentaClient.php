<?php

namespace App\HttpClients;

use App\Entity\YouRenta\YouRentaAdvertisement;
use App\Entity\YouRenta\YouRentaUser;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use PharIo\Manifest\InvalidUrlException;
use Symfony\Component\Panther\Client;
use Symfony\Component\Panther\DomCrawler\Crawler;
use Symfony\Component\Panther\DomCrawler\Form;
use Vich\UploaderBundle\Storage\StorageInterface;

/**
 * Клиент для работы с сайтом YouRenta
 */
class YouRentaClient
{
    /** @var string URL списка объявлений пользователя */
    public const URL_ADVERTISEMENT_LIST = 'user-index.html';

    private $client;
    /**
     * @var StorageInterface
     */
    private $storage;

    public function __construct(StorageInterface $storage)
    {
        // Все настройки клиента через окружение
        $this->client = Client::createChromeClient(null, null, [],'https://yourenta.ru');
        $this->storage = $storage;
    }

    /**
     * Получить XPath для поиска объявления в списке объявлений
     * @param YouRentaAdvertisement $advertisement
     *
     * @return string
     */
    public function getXpathDeleteAdvertisementButton(YouRentaAdvertisement $advertisement): string
    {
        $text = Crawler::xpathLiteral(
            implode(', ', [$advertisement->getStreet(), $advertisement->getBuildingNumber()])
        );

        return  "descendant::a[contains(string(.), $text)]/" .
                "./ancestor::div[contains(@class, 'rd')]/descendant::a[contains(string(.), 'удалить')]";
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
     *
     * @param YouRentaUser $user Пользователь, под которым необходимо авторизоваться
     *
     * @return YouRentaClient
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     * @throws \Facebook\WebDriver\Exception\TimeoutException
     * @see \App\Tests\HttpClients\YouRentaClientTest::testAuthorize unit test
     * @see \App\Tests\HttpClients\YouRentaClientTest::testAuthorizeUsersInRow unit test
     */
    public function authorize(YouRentaUser $user): self
    {
        $crawler = $this->getClient()->get('/login.html')->getCrawler();
        $crawler->filter('#login-form')->form(['enter_email' => $user->getLogin(), 'enter_pass' => $user->getPassword()]);
        $this->getClient()->findElement(WebDriverBy::id('uniform-enter'));
        $crawler->filter('#uniform-enter')->first()->click();
        $this->client->waitFor('#cabinetcontent');
        $this->client->findElement(WebDriverBy::id('my-flat'))->click();
        $this->client->waitFor('.mainflat');

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
            $form->get('img' . ($key + 1))->upload($this->storage->resolvePath($photo));
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
     *
     * @return YouRentaClient
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     * @throws \Facebook\WebDriver\Exception\TimeoutException
     * @see \App\Tests\HttpClients\YouRentaClientTest::testAddAndDeleteAdvertisement unit test
     * @see \App\Tests\HttpClients\YouRentaClientTest::testAddAndDeleteMultipleAdvertisements unit test
     *
     */
    public function deleteAdvertisement(YouRentaAdvertisement $advertisement): self
    {
        if (strpos($this->getClient()->getCurrentURL(), self::URL_ADVERTISEMENT_LIST) < 0) {
            throw new InvalidUrlException('current url must contain' . self::URL_ADVERTISEMENT_LIST);
        }
        /** @var Crawler Парсер блока редактирования объявления */
        $crawler = $this
            ->getClient()
            ->getCrawler()
            ->filterXPath($this->getXpathDeleteAdvertisementButton($advertisement))
        ;
        if ($crawler->count()) {
            $this->removeFixedFooter();
            $this->getClient()
                ->findElement(WebDriverBy::xpath($this->getXpathDeleteAdvertisementButton($advertisement)))
                ->click()
            ;
            $this->getClient()->wait(WebDriverExpectedCondition::alertIsPresent());
            $this->getClient()->getWebDriver()->switchTo()->alert()->accept();
            $this->getClient()->wait()->until(
                WebDriverExpectedCondition::elementToBeClickable(WebDriverBy::id('fancybox-close'))
            );
            $this->getClient()->findElement(WebDriverBy::id('fancybox-close'))->click();
            $this->getClient()->wait(
                WebDriverExpectedCondition::invisibilityOfElementLocated(WebDriverBy::id('fancybox-close'))
            );
        }

        return $this;
    }

    /**
     * Удалить зафиксированный футер с соцсетями.
     * Из-за того, что он зафиксирован, он мешает кликать на элементы, которые находятся под ним.
     */
    private function removeFixedFooter()
    {
        $this->getClient()->waitFor('#fb-root');
        $this->getClient()->executeScript("document.getElementById('fb-root').remove()");
        $this->getClient()->waitFor('.s70');
        $this->getClient()->executeScript("document.querySelector('.s70').remove()");
    }
}
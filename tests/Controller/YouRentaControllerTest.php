<?php

namespace App\Tests;

use App\Controller\YouRentaController;
use App\Entity\YouRenta\YouRentaAd;
use Facebook\WebDriver\WebDriverBy;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Panther\DomCrawler\Form;
use Symfony\Component\Panther\PantherTestCase;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @coversDefaultClass \App\Controller\YouRentaController
 */
class YouRentaControllerTest extends PantherTestCase
{
    /** @var \Symfony\Component\Panther\Client */
    private $client;
    private $login;
    private $password;
    /** @var Serializer */
    private $serializer;

    protected function setUp() : void
    {
        parent::setUp();
        $this->client = static::createPantherClient(['external_base_uri' => 'https://yourenta.ru']);
        $this->login = 'gfdh6@mail.ru';
        $this->password = 444444;
        $this->serializer = new Serializer([
            new ObjectNormalizer(null, new CamelCaseToSnakeCaseNameConverter()),
            new ArrayDenormalizer()
                                               ]);
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
        $ad = $this->createYouRentaAd();
        $this->authorize();
        $this->client->request('GET', '/add-flat.html');
        $crawler = $this->client->getCrawler();
        /** @var Form $form Форма добавления объявления */
        $form = $crawler->filter('form[action="//yourenta.ru/user-add-flat.html"]')->form();

        $form->setValues($this->serializer->normalize(
            $ad,
            null,
            [
                AbstractNormalizer::ATTRIBUTES => [
                    'objectF',
                    'rayonF',
                    'adresF',
                    'homeF',
                    'rooms',
                    'priceD',
                    'priceH',
                    'guest',
                    'etag',
                    'etagAll',
                    'phone1',
                ],
            ]
        ));
        $crawler->findElement(WebDriverBy::cssSelector('a[href="#tabs-2"]'))->click();
        $form->setValues($this->serializer->normalize(
            $ad,
            null,
            [AbstractNormalizer::ATTRIBUTES => ['inet', 'sm', 'parkovka_f', 'dop']]
        ));
        $crawler->findElement(WebDriverBy::cssSelector('a[href="#tabs-3"]'))->click();
        foreach ($ad->getImg() as $key => $img) {
            $form->get('img' . $key + 1)->upload($img);
        }
        //$this->client->submit($form);
        $this->client->waitFor('#id');
    }

    /**
     * Создать объект объявления
     * @return YouRentaAd
     */
    private function createYouRentaAd() : YouRentaAd
    {
        $data = [
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
            'img' => [
                '/home/ldmitriev/projects/ads-manager/public/img/yourenta/pobedy-35/4-1--ул.  Победы  35.png',
                '/home/ldmitriev/projects/ads-manager/public/img/yourenta/pobedy-35/4-2--ул.  Победы  35.png',
                '/home/ldmitriev/projects/ads-manager/public/img/yourenta/pobedy-35/4-3--ул.  Победы  35.png',
                '/home/ldmitriev/projects/ads-manager/public/img/yourenta/pobedy-35/4-4--ул.  Победы  35.png',
                '/home/ldmitriev/projects/ads-manager/public/img/yourenta/pobedy-35/4-5--ул.  Победы  35.png',
            ],
        ];
        return $this->serializer->denormalize($data, YouRentaAd::class);
    }
}

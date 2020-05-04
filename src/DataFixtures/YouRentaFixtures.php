<?php

namespace App\DataFixtures;

use App\Entity\YouRenta\YouRentaCity;
use App\Entity\YouRenta\YouRentaCityDistrict;
use App\Entity\YouRenta\YouRentaGuestCount;
use App\Entity\YouRenta\YouRentaObjectType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Класс для заполнения таблиц yourenta данными
 */
class YouRentaFixtures extends Fixture
{
    /** @inheritDoc */
    public function load(ObjectManager $manager)
    {
        // Заполнение типов объектов
        for ($i = 1; $i <= 2; $i++) {
            $objectType = new YouRentaObjectType();
            $objectType->setName($i === 1 ? 'Квартира' : 'Коттедж');
            $objectType->setValue('1');
            $manager->persist($objectType);
        }
        // Заполнение города
        $city = new YouRentaCity();
        $city->setName('Тольятти');
        $manager->persist($city);
        // Заполнение районов города
        for ($i = 1 ; $i <= 3; $i++) {
            $district = new YouRentaCityDistrict();
            $name = $i === 1 ? 'Автозаводский' : ($i === 2 ? 'Комсомольский' : 'Центальный');
            $district->setName($name);
            $district->setValue($i);
            $city->addDistrict($district);
            $manager->persist($district);
        }
        // Описываем кол-во гостей
        for ($i = 1; $i <= 11; $i++) {
            $guestCount = new YouRentaGuestCount();
            $guestCount->setValue($i);
            $i <= 10
                ? $guestCount->setName("$i человек")
                : $guestCount->setName("> 10 человек");
            $manager->persist($guestCount);
        }

        $manager->flush();
    }
}

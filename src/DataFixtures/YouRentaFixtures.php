<?php

namespace App\DataFixtures;

use App\Entity\YouRenta\YouRentaCity;
use App\Entity\YouRenta\YouRentaObjectType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Класс для заполнения таблиц yourenta данными
 */
class YouRentaFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $objectTypeFlat = new YouRentaObjectType();
        $objectTypeFlat->setName('Квартира');
        $objectTypeFlat->setValue('1');
        $manager->persist($objectTypeFlat);
        $objectTypeCottage = new YouRentaObjectType();
        $objectTypeCottage->setName('Коттедж');
        $objectTypeCottage->setValue('2');
        $manager->persist($objectTypeCottage);

        $city = new YouRentaCity();
        $city->setName('Тольятти');
        $manager->persist($city);
        $manager->flush();
    }
}

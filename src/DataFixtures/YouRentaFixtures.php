<?php

namespace App\DataFixtures;

use App\Entity\YouRenta\YouRentaCity;
use App\Entity\YouRenta\YouRentaCityDistrict;
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
        // Заполнение типов объектов
        $objectTypeFlat = new YouRentaObjectType();
        $objectTypeFlat->setName('Квартира');
        $objectTypeFlat->setValue('1');
        $manager->persist($objectTypeFlat);
        $objectTypeCottage = new YouRentaObjectType();
        $objectTypeCottage->setName('Коттедж');
        $objectTypeCottage->setValue('2');
        $manager->persist($objectTypeCottage);
        // Заполнение города
        $city = new YouRentaCity();
        $city->setName('Тольятти');
        // Заполнение районов города
        $districtCentral = new YouRentaCityDistrict();
        $districtCentral->setName('Центальный');
        $districtCentral->setValue(3);
        $manager->persist($districtCentral);
        $city->addDistrict($districtCentral);
        $disctictKomsomolsky = new YouRentaCityDistrict();
        $disctictKomsomolsky->setName('Комсомольский');
        $disctictKomsomolsky->setValue(2);
        $manager->persist($disctictKomsomolsky);
        $city->addDistrict($disctictKomsomolsky);
        $disctictAvtozavodsky = new YouRentaCityDistrict();
        $disctictAvtozavodsky->setName('Автозаводский');
        $disctictAvtozavodsky->setValue(1);
        $city->addDistrict($disctictAvtozavodsky);
        $manager->persist($disctictAvtozavodsky);
        $manager->persist($city);
        $manager->flush();
    }
}

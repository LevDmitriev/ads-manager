<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\YouRenta\YouRentaObjectType;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Миграция добавления типов объектов
 */
final class Version20200419193237 extends AbstractMigration implements ContainerAwareInterface
{
   use ContainerAwareTrait;

    public function getDescription() : string
    {
        return 'Добавить типы объектов yourenta';
    }

    public function up(Schema $schema) : void
    {
        $object = new YouRentaObjectType();
        $object->setName('Квартира');
        $object->setValue('1');
        $entityManager = $this->container->get('doctrine.orm.default_entity_manager');
        $entityManager->persist($object);
        $object2 = new YouRentaObjectType();
        $object2->setName('Коттедж');
        $object2->setValue('2');
        $entityManager->persist($object2);
        $entityManager->flush();
    }

    public function down(Schema $schema) : void
    {
        $entityManager = $this->container->get('doctrine.orm.default_entity_manager');
        $repository = $entityManager->getRepository(YouRentaObjectType::class);
        $entityManager->remove($repository->findOneBy(['value' => 1]));
        $entityManager->remove($repository->findOneBy(['value' => 2]));
        $entityManager->flush();
    }

}

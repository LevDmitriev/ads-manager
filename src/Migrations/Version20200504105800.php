<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\YouRenta\YouRentaCity;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Миграция добавления типов объектов
 */
final class Version20200504105800 extends AbstractMigration implements ContainerAwareInterface
{
   use ContainerAwareTrait;

    public function getDescription() : string
    {
        return 'Добавить города yourenta';
    }

    public function up(Schema $schema) : void
    {
        $object = new YouRentaCity();
        $object->setName('Тольятти');
        $entityManager = $this->container->get('doctrine.orm.default_entity_manager');
        $entityManager->persist($object);
        $entityManager->flush();
    }

    public function down(Schema $schema) : void
    {
        $entityManager = $this->container->get('doctrine.orm.default_entity_manager');
        $repository = $entityManager->getRepository(YouRentaCity::class);
        $entityManager->remove($repository->findOneBy(['name' => 'Тольятти']));
        $entityManager->flush();
    }

}

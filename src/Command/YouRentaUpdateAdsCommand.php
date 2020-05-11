<?php

namespace App\Command;

use App\Entity\YouRenta\YouRentaAdvertisement;
use App\Entity\YouRenta\YouRentaUser;
use App\HttpClients\YouRentaClient;
use App\Repository\YouRenta\YouRentaAdvertisementRepository;
use App\Repository\YouRenta\YouRentaAdvertisementUpdatePeriodRepository;
use App\Repository\YouRenta\YouRentaUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Команда для обновления объявлений YouRenta
 */
class YouRentaUpdateAdsCommand extends Command
{
    /**
     * @var YouRentaUserRepository
     */
    private $userRepository;
    /**
     * @var YouRentaClient
     */
    private $client;

    public function __construct(
        YouRentaUserRepository $userRepository,
        YouRentaClient $client
    )
    {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->client = $client;
    }
    protected static $defaultName = 'yourenta:update:ads';

    /** @inheritDoc */
    protected function configure()
    {
        $this->setDescription('Начать обновление объявлений YouRenta');
        $this->addOption('period', 'p', InputOption::VALUE_REQUIRED, 'Период обновления объявлений в секундах', 3600);
    }

    /** @inheritDoc */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        /** @var int Кол-во секунд ожидания */
        $period = (int) $input->getOption('period');
        while (true) {
            $users = $this->userRepository->findAll();
            foreach ($users as $user) {
                $this->client->authorize($user);
                /** @var ArrayCollection<YouRentaAdvertisement> $advertisements Все объявления пользователя */
                foreach ($user->getAdvertisements() as $advertisement) {
                    $this->client->deleteAdvertisement($advertisement);
                    $this->client->addAdvertisement($advertisement);
                }

                $io->writeln(implode(' ',
                                      [
                                          'Объявления',
                                          'пользователя',
                                          $user->getLogin(),
                                          'обновлены',
                                          (new \DateTime())->format('Y-m-d H:i:s'),
                                      ]
                              ));
            }
            $io->writeln("Ждём $period секунд");
            sleep($period);
        }

        return 0;
    }
}

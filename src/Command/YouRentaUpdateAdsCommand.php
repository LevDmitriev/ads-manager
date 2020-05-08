<?php

namespace App\Command;

use App\Entity\YouRenta\YouRentaAdvertisement;
use App\Entity\YouRenta\YouRentaUser;
use App\HttpClients\YouRentaClient;
use App\Repository\YouRenta\YouRentaAdvertisementRepository;
use App\Repository\YouRenta\YouRentaAdvertisementUpdatePeriodRepository;
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
     * @var YouRentaAdvertisementRepository
     */
    private $advertisementRepository;
    /**
     * @var YouRentaAdvertisementUpdatePeriodRepository
     */
    private $periodRepository;
    /**
     * @var YouRentaClient
     */
    private $client;

    public function __construct(
        YouRentaAdvertisementRepository $advertisementRepository,
        YouRentaAdvertisementUpdatePeriodRepository $periodRepository,
        YouRentaClient $client
    )
    {
        parent::__construct();
        $this->advertisementRepository = $advertisementRepository;
        $this->periodRepository = $periodRepository;
        $this->client = $client;
    }
    protected static $defaultName = 'you-renta:update:ads';

    protected function configure()
    {
        $this->setDescription('Начать обновление объявлений YouRenta');
        $this->addOption('period', 'p', InputOption::VALUE_REQUIRED, 'Период обновления объявлений в секундах', 3600);
    }

    /** @inheritDoc */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        /** @var int $period Кол-во секунд ожидания */
        $period = (int) $input->getOption('period');
        /** @var ArrayCollection|YouRentaAdvertisement[] $advertisements Все объявления */
        $advertisements = new ArrayCollection();
        array_map(function ($advertisement) use ($advertisements) {
            $advertisements->add($advertisement);
        }, $this->advertisementRepository->findAll());
        /** @var ArrayCollection|YouRentaUser[] $users Пользователи, которым пренадлежат объявления */
        $users = new ArrayCollection();
        $advertisements->map(function($advertisement) use ($users) {
            /** @var YouRentaAdvertisement $advertisement */
            if (!$users->contains($advertisement->getUser())) {
                $users->add($advertisement->getUser());
            }
        });
        while (true) {
            foreach ($users as $user) {
                $this->client->authorize($user);
                /** @var ArrayCollection<YouRentaAdvertisement> $advertisements Все объявления пользователя */
                $userAdvertisements = $advertisements->filter(
                    function ($advertisement) use ($user) {
                        /** @var YouRentaAdvertisement $advertisement */
                        return $advertisement->getUser() === $user;
                    }
                );
                foreach ($userAdvertisements as $advertisement) {
                    $this->client->deleteAdvertisement($advertisement);
                    $this->client->addAdvertisement($advertisement);
                }
                $io->writeln('Объявления пользователя ' . $user->getLogin() . ' обновлены');
            }
            $io->writeln("Ждём $period секунд");
            sleep($period);
        }

        return 0;
    }
}

<?php

namespace App\Entity\YouRenta;

use Doctrine\ORM\Mapping as ORM;

/**
 * Модель с интервалами обновления объявлений YouRenta
 * @ORM\Entity(repositoryClass="App\Repository\YouRenta\YouRentaAdvertisementUpdatePeriodRepository")
 */
class YouRentaAdvertisementUpdatePeriod
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\YouRenta\YouRentaAdvertisement", inversedBy="updatePeriod", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $advertisement;

    /**
     * @ORM\Column(type="dateinterval")
     */
    private $period;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdvertisement(): ?YouRentaAdvertisement
    {
        return $this->advertisement;
    }

    public function setAdvertisement(YouRentaAdvertisement $advertisement): self
    {
        $this->advertisement = $advertisement;

        return $this;
    }

    public function getPeriod(): ?\DateInterval
    {
        return $this->period;
    }

    public function setPeriod(\DateInterval $period): self
    {
        $this->period = $period;

        return $this;
    }
}

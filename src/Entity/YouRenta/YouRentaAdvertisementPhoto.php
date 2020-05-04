<?php

namespace App\Entity\YouRenta;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\YouRenta\YouRentaAdvertisementPhotoRepository")
 */
class YouRentaAdvertisementPhoto
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fileName;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\YouRenta\YouRentaAdvertisement", inversedBy="photos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $advertisement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getAdvertisement(): ?YouRentaAdvertisement
    {
        return $this->advertisement;
    }

    public function setAdvertisement(?YouRentaAdvertisement $advertisement): self
    {
        $this->advertisement = $advertisement;

        return $this;
    }
}

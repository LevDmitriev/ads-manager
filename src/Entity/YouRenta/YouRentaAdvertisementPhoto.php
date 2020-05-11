<?php

namespace App\Entity\YouRenta;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
/**
 * @ORM\Entity(repositoryClass="App\Repository\YouRenta\YouRentaAdvertisementPhotoRepository")
 * @Vich\Uploadable()
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
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="yourenta_advertisement_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\YouRenta\YouRentaAdvertisement", inversedBy="photos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $advertisement;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image) : void
    {
        $this->image = $image;
    }

    public function getImageFile() : ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile) : void
    {
        $this->imageFile = $imageFile;
        if ($imageFile) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getCreatedAt() : \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt) : void
    {
        $this->createdAt = $createdAt;
    }
}

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
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\YouRenta\YouRentaAdvertisement", inversedBy="photos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $advertisement;

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

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image) : void
    {
        $this->image = $image;
    }

    public function getImageFile() : File
    {
        return $this->imageFile;
    }

    public function setImageFile(File $imageFile = null) : void
    {
        $this->imageFile = $imageFile;
        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($imageFile) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }
}

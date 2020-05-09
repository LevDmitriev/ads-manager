<?php

namespace App\Entity\YouRenta;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\YouRenta\YouRentaCityDistrictRepository")
 */
class YouRentaCityDistrict
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\YouRenta\YouRentaCity", inversedBy="districts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $city;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\YouRenta\YouRentaAdvertisement", mappedBy="district")
     */
    private $advertisements;

    public function __construct()
    {
        $this->advertisements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getCity(): ?YouRentaCity
    {
        return $this->city;
    }

    public function setCity(?YouRentaCity $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function addAdvertisement(YouRentaAdvertisement $advertisement)
    {
        $this->advertisements->add($advertisement);
    }

    public function removeAdvertisement(YouRentaAdvertisement $advertisement)
    {
        $this->advertisements->removeElement($advertisement);
    }
}

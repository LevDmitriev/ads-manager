<?php

namespace App\Entity\YouRenta;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\YouRenta\YouRentaAdvertisementRepository")
 */
class YouRentaAdvertisement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\YouRenta\YouRentaObjectType", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $objectType;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\YouRenta\YouRentaCity", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $city;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\YouRenta\YouRentaCityDistrict", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $district;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $buildingNumber;

    /**
     * @ORM\Column(type="smallint")
     */
    private $roomsNumber;

    /**
     * @ORM\Column(type="integer")
     */
    private $priceDay;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $priceNight;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $priceHour;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $priceWedding;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\YouRenta\YouRentaGuestCount", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $guestCount;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $floor;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $floorsCount;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $totalArea;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstPhone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $secondPhone;

    /**
     * @ORM\Column(type="boolean")
     */
    private $internet;

    /**
     * @ORM\Column(type="boolean")
     */
    private $conditioner;

    /**
     * @ORM\Column(type="boolean")
     */
    private $washer;

    /**
     * @ORM\Column(type="boolean")
     */
    private $parking;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $rentConditions;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $rentConditionsWedding;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $youTube;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\YouRenta\YouRentaAdvertisementPhoto", mappedBy="advertisement", orphanRemoval=true, cascade={"persist"})
     */
    private $photos;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\YouRenta\YouRentaUser", inversedBy="advertisements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObjectType(): ?YouRentaObjectType
    {
        return $this->objectType;
    }

    public function setObjectType(YouRentaObjectType $objectType): self
    {
        $this->objectType = $objectType;

        return $this;
    }

    public function getCity(): ?YouRentaCity
    {
        return $this->city;
    }

    public function setCity(YouRentaCity $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getDistrict(): ?YouRentaCityDistrict
    {
        return $this->district;
    }

    public function setDistrict(YouRentaCityDistrict $district): self
    {
        $this->district = $district;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getBuildingNumber(): ?string
    {
        return $this->buildingNumber;
    }

    public function setBuildingNumber(string $buildingNumber): self
    {
        $this->buildingNumber = $buildingNumber;

        return $this;
    }

    public function getRoomsNumber(): ?int
    {
        return $this->roomsNumber;
    }

    public function setRoomsNumber(int $roomsNumber): self
    {
        $this->roomsNumber = $roomsNumber;

        return $this;
    }

    public function getPriceDay(): ?int
    {
        return $this->priceDay;
    }

    public function setPriceDay(int $priceDay): self
    {
        $this->priceDay = $priceDay;

        return $this;
    }

    public function getPriceNight(): ?int
    {
        return $this->priceNight;
    }

    public function setPriceNight(?int $priceNight): self
    {
        $this->priceNight = $priceNight;

        return $this;
    }

    public function getPriceHour(): ?int
    {
        return $this->priceHour;
    }

    public function setPriceHour(?int $priceHour): self
    {
        $this->priceHour = $priceHour;

        return $this;
    }

    public function getPriceWedding(): ?int
    {
        return $this->priceWedding;
    }

    public function setPriceWedding(?int $priceWedding): self
    {
        $this->priceWedding = $priceWedding;

        return $this;
    }

    public function getGuestCount(): ?YouRentaGuestCount
    {
        return $this->guestCount;
    }

    public function setGuestCount(YouRentaGuestCount $guestCount): self
    {
        $this->guestCount = $guestCount;

        return $this;
    }

    public function getFloor(): ?int
    {
        return $this->floor;
    }

    public function setFloor(?int $floor): self
    {
        $this->floor = $floor;

        return $this;
    }

    public function getFloorsCount(): ?int
    {
        return $this->floorsCount;
    }

    public function setFloorsCount(?int $floorsCount): self
    {
        $this->floorsCount = $floorsCount;

        return $this;
    }

    public function getTotalArea(): ?float
    {
        return $this->totalArea;
    }

    public function setTotalArea(?float $totalArea): self
    {
        $this->totalArea = $totalArea;

        return $this;
    }

    public function getFirstPhone(): ?string
    {
        return $this->firstPhone;
    }

    public function setFirstPhone(string $firstPhone): self
    {
        $this->firstPhone = $firstPhone;

        return $this;
    }

    public function getSecondPhone(): ?string
    {
        return $this->secondPhone;
    }

    public function setSecondPhone(?string $secondPhone): self
    {
        $this->secondPhone = $secondPhone;

        return $this;
    }

    public function getInternet(): ?bool
    {
        return $this->internet;
    }

    public function setInternet(bool $internet): self
    {
        $this->internet = $internet;

        return $this;
    }

    public function getConditioner(): ?bool
    {
        return $this->conditioner;
    }

    public function setConditioner(bool $conditioner): self
    {
        $this->conditioner = $conditioner;

        return $this;
    }

    public function getWasher(): ?bool
    {
        return $this->washer;
    }

    public function setWasher(bool $washer): self
    {
        $this->washer = $washer;

        return $this;
    }

    public function getParking(): ?bool
    {
        return $this->parking;
    }

    public function setParking(bool $parking): self
    {
        $this->parking = $parking;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getRentConditions(): ?string
    {
        return $this->rentConditions;
    }

    public function setRentConditions(?string $rentConditions): self
    {
        $this->rentConditions = $rentConditions;

        return $this;
    }

    public function getRentConditionsWedding(): ?string
    {
        return $this->rentConditionsWedding;
    }

    public function setRentConditionsWedding(?string $rentConditionsWedding): self
    {
        $this->rentConditionsWedding = $rentConditionsWedding;

        return $this;
    }

    public function getYouTube(): ?string
    {
        return $this->youTube;
    }

    public function setYouTube(?string $youTube): self
    {
        $this->youTube = $youTube;

        return $this;
    }

    /**
     * @return Collection|YouRentaAdvertisementPhoto[]
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(YouRentaAdvertisementPhoto $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setAdvertisement($this);
        }

        return $this;
    }

    public function removePhoto(YouRentaAdvertisementPhoto $photo): self
    {
        if ($this->photos->contains($photo)) {
            $this->photos->removeElement($photo);
            // set the owning side to null (unless already changed)
            if ($photo->getAdvertisement() === $this) {
                $photo->setAdvertisement(null);
            }
        }

        return $this;
    }

    public function getUser(): ?YouRentaUser
    {
        return $this->user;
    }

    public function setUser(?YouRentaUser $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function __toString()
    {
        return implode(
            ' ',
            [
                $this->getCity()->getName(),
                $this->getDistrict(),
                'район',
                $this->getStreet(),
                $this->getBuildingNumber(),
            ]
        );
    }
}

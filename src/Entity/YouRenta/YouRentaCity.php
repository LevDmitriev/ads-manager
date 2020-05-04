<?php

namespace App\Entity\YouRenta;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\YouRenta\YouRentaCityRepository")
 */
class YouRentaCity
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
     * @ORM\OneToOne(targetEntity="App\Entity\YouRenta\YouRentaCityDistrict", mappedBy="city", cascade={"persist", "remove"})
     */
    private $districts;

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

    public function getDistricts(): ?YouRentaCityDistrict
    {
        return $this->districts;
    }

    public function setDistricts(YouRentaCityDistrict $districts): self
    {
        $this->districts = $districts;

        // set the owning side of the relation if necessary
        if ($districts->getCity() !== $this) {
            $districts->setCity($this);
        }

        return $this;
    }
}

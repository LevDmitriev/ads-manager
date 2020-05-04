<?php

namespace App\Entity\YouRenta;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\OneToMany(targetEntity="App\Entity\YouRenta\YouRentaCityDistrict", mappedBy="city", orphanRemoval=true)
     */
    private $districts;

    public function __construct()
    {
        $this->districts = new ArrayCollection();
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

    /**
     * @return Collection|YouRentaCityDistrict[]
     */
    public function getDistricts(): Collection
    {
        return $this->districts;
    }

    public function addDistrict(YouRentaCityDistrict $district): self
    {
        if (!$this->districts->contains($district)) {
            $this->districts[] = $district;
            $district->setCity($this);
        }

        return $this;
    }

    public function removeDistrict(YouRentaCityDistrict $district): self
    {
        if ($this->districts->contains($district)) {
            $this->districts->removeElement($district);
            // set the owning side to null (unless already changed)
            if ($district->getCity() === $this) {
                $district->setCity(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }
}

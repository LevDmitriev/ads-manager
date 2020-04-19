<?php

namespace App\Entity\YouRenta;

/**
 * Объявление
 */
class YouRentaAd
{
    /** @var int Тип объекта */
    private $objectF;
    /** @var int Район города */
    private $rayonF;
    /** @var string Улица */
    private $adresF;
    /** @var int Номер дома */
    private $homeF;
    /** @var int Кол-во комнат */
    private $rooms;
    /** @var int Цена за день */
    private $priceD;
    /** @var int Цена за час */
    private $priceH;
    /** @var int Максимальное кол-во гостей */
    private $guest;
    /** @var int Этаж */
    private $etag;
    /** @var int Общее кол-во этажей */
    private $etagAll;
    /** @var string Телефон */
    private $phone1;
    /** @var boolean Интернет */
    private $inet;
    /** @var boolean Стиральная машина */
    private $sm;
    /** @var boolean Парковка */
    private $parkovkaF;
    /** @var boolean Описание */
    private $dop;
    /** @var string[] Изображения */
    private $img;

    /**
     * @return int
     */
    public function getObjectF() : int
    {
        return $this->objectF;
    }

    /**
     * @param int $objectF
     *
     * @return YouRentaAd
     */
    public function setObjectF(int $objectF) : YouRentaAd
    {
        $this->objectF = $objectF;

        return $this;
    }

    /**
     * @return int
     */
    public function getRayonF() : int
    {
        return $this->rayonF;
    }

    /**
     * @param int $rayonF
     *
     * @return YouRentaAd
     */
    public function setRayonF(int $rayonF) : YouRentaAd
    {
        $this->rayonF = $rayonF;

        return $this;
    }

    /**
     * @return string
     */
    public function getAdresF() : string
    {
        return $this->adresF;
    }

    /**
     * @param string $adresF
     *
     * @return YouRentaAd
     */
    public function setAdresF(string $adresF) : YouRentaAd
    {
        $this->adresF = $adresF;

        return $this;
    }

    /**
     * @return int
     */
    public function getHomeF() : int
    {
        return $this->homeF;
    }

    /**
     * @param int $homeF
     *
     * @return YouRentaAd
     */
    public function setHomeF(int $homeF) : YouRentaAd
    {
        $this->homeF = $homeF;

        return $this;
    }

    /**
     * @return int
     */
    public function getRooms() : int
    {
        return $this->rooms;
    }

    /**
     * @param int $rooms
     *
     * @return YouRentaAd
     */
    public function setRooms(int $rooms) : YouRentaAd
    {
        $this->rooms = $rooms;

        return $this;
    }

    /**
     * @return int
     */
    public function getPriceD() : int
    {
        return $this->priceD;
    }

    /**
     * @param int $priceD
     *
     * @return YouRentaAd
     */
    public function setPriceD(int $priceD) : YouRentaAd
    {
        $this->priceD = $priceD;

        return $this;
    }

    /**
     * @return int
     */
    public function getPriceH() : int
    {
        return $this->priceH;
    }

    /**
     * @param int $priceH
     *
     * @return YouRentaAd
     */
    public function setPriceH(int $priceH) : YouRentaAd
    {
        $this->priceH = $priceH;

        return $this;
    }

    /**
     * @return int
     */
    public function getGuest() : int
    {
        return $this->guest;
    }

    /**
     * @param int $guest
     *
     * @return YouRentaAd
     */
    public function setGuest(int $guest) : YouRentaAd
    {
        $this->guest = $guest;

        return $this;
    }

    /**
     * @return int
     */
    public function getEtag() : int
    {
        return $this->etag;
    }

    /**
     * @param int $etag
     *
     * @return YouRentaAd
     */
    public function setEtag(int $etag) : YouRentaAd
    {
        $this->etag = $etag;

        return $this;
    }

    /**
     * @return int
     */
    public function getEtagAll() : int
    {
        return $this->etagAll;
    }

    /**
     * @param int $etagAll
     *
     * @return YouRentaAd
     */
    public function setEtagAll(int $etagAll) : YouRentaAd
    {
        $this->etagAll = $etagAll;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone1() : string
    {
        return $this->phone1;
    }

    /**
     * @param string $phone1
     *
     * @return YouRentaAd
     */
    public function setPhone1(string $phone1) : YouRentaAd
    {
        $this->phone1 = $phone1;

        return $this;
    }

    /**
     * @return bool
     */
    public function isInet() : bool
    {
        return $this->inet;
    }

    /**
     * @param bool $inet
     *
     * @return YouRentaAd
     */
    public function setInet(bool $inet) : YouRentaAd
    {
        $this->inet = $inet;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSm() : bool
    {
        return $this->sm;
    }

    /**
     * @param bool $sm
     *
     * @return YouRentaAd
     */
    public function setSm(bool $sm) : YouRentaAd
    {
        $this->sm = $sm;

        return $this;
    }

    /**
     * @return bool
     */
    public function isParkovkaF() : bool
    {
        return $this->parkovkaF;
    }

    /**
     * @param bool $parkovkaF
     *
     * @return YouRentaAd
     */
    public function setParkovkaF(bool $parkovkaF) : YouRentaAd
    {
        $this->parkovkaF = $parkovkaF;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDop() : bool
    {
        return $this->dop;
    }

    /**
     * @param bool $dop
     *
     * @return YouRentaAd
     */
    public function setDop(bool $dop) : YouRentaAd
    {
        $this->dop = $dop;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getImg() : array
    {
        return $this->img;
    }

    /**
     * @param string[] $img
     */
    public function setImg(array $img) : YouRentaAd
    {
        $this->img = $img;

        return $this;
    }
}
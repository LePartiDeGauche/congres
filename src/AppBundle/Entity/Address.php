<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Address.
 *
 * @ORM\Table(name="address")
 * @ORM\Entity
 */
class Address
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="streetNumber", type="string", length=20)
     */
    private $streetNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="streetType", type="string", length=255)
     */
    private $streetType;

    /**
     * @var string
     *
     * @ORM\Column(name="streetName", type="string", length=255)
     */
    private $streetName;

    /**
     * @var string
     *
     * @ORM\Column(name="cityCode", type="string", length=255)
     */
    private $cityCode;

    /**
     * @var string
     *
     * @ORM\Column(name="cityName", type="string", length=255)
     */
    private $cityName;

    /**
     * Get id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set streetNumber.
     *
     * @param string $streetNumber
     *
     * @return Address
     */
    public function setStreetNumber($streetNumber)
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    /**
     * Get streetNumber.
     *
     * @return string
     */
    public function getStreetNumber()
    {
        return $this->streetNumber;
    }

    /**
     * Set streetType.
     *
     * @param string $streetType
     *
     * @return Address
     */
    public function setStreetType($streetType)
    {
        $this->streetType = $streetType;

        return $this;
    }

    /**
     * Get streetType.
     *
     * @return string
     */
    public function getStreetType()
    {
        return $this->streetType;
    }

    /**
     * Set streetName.
     *
     * @param string $streetName
     *
     * @return Address
     */
    public function setStreetName($streetName)
    {
        $this->streetName = $streetName;

        return $this;
    }

    /**
     * Get streetName.
     *
     * @return string
     */
    public function getStreetName()
    {
        return $this->streetName;
    }

    /**
     * Set cityCode.
     *
     * @param string $cityCode
     *
     * @return Address
     */
    public function setCityCode($cityCode)
    {
        $this->cityCode = $cityCode;

        return $this;
    }

    /**
     * Get cityCode.
     *
     * @return string
     */
    public function getCityCode()
    {
        return $this->cityCode;
    }

    /**
     * Set cityName.
     *
     * @param string $cityName
     *
     * @return Address
     */
    public function setCityName($cityName)
    {
        $this->cityName = $cityName;

        return $this;
    }

    /**
     * Get cityName.
     *
     * @return string
     */
    public function getCityName()
    {
        return $this->cityName;
    }

    public function __toString()
    {
        return $this->streetNumber.', '.$this->streetName.' '.
            $this->cityCode.' '.$this->cityName;
    }
}

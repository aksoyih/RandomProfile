<?php

namespace Aksoyih\RandomProfile;

use Faker\Generator;

class Address
{
    public $fullAddress;
    public $city;
    public $district;
    public $street;
    public $apartmentNumber;
    public $postalCode;
    public $timeZone;
    public $coordinates;
    public $openstreetmap_link;

    private $data;
    /**
     * @var Helper
     */
    private $helper;


    /**
     *
     */
    public function __construct()
    {
        $this->helper = new Helper();
        $this->loadData();

        $this->setFullAddress();

        $this->setPostalCode();
        $this->setTimeZone();
    }

    /**
     * @return void
     */
    public function loadData()
    {
        $address_data = $this->helper->getAddressData();
        $random_address_index = array_rand($address_data);
        $this->data = $address_data[$random_address_index];
    }

    /**
     * Creates and sets a full address
     * @return void
     */
    public function setFullAddress()
    {
        $this->setCity();
        $this->setStreet();
        $this->setDistrict();
        $this->setApartmentNumber();
        $this->setCoordinates($this->city);
        $this->setOpenstreetmapLink();

        $this->fullAddress = "{$this->street} {$this->district} {$this->apartmentNumber} / {$this->postalCode} {$this->city}";
    }

    /**
     * @return void
     */
    public function setCity()
    {
        $this->city = $this->helper->ucfirst($this->helper->strtolower($this->data[2]), 'UTF-8');
    }

    /**
     * @return void
     */
    public function setStreet()
    {
        $this->street = $this->helper->ucfirst($this->helper->strtolower($this->data[0]), 'UTF-8');
    }

    /**
     * @return void
     */
    public function setDistrict()
    {
        $this->district = $this->helper->ucfirst($this->helper->strtolower($this->data[1]), 'UTF-8');
    }

    /**
     * @return void
     */
    public function setApartmentNumber()
    {
        $this->apartmentNumber = rand(1, 99);
    }

    /**
     * @param $city
     * @return void
     */
    public function setCoordinates($city)
    {
        $coordinateData = $this->helper->getCoordinateData();

        if (isset($coordinateData[$city])) {
            $this->coordinates['latitute'] = $coordinateData[$city][0];
            $this->coordinates['longitute'] = $coordinateData[$city][1];
        } else {
            $this->coordinates['latitute'] = 0.00;
            $this->coordinates['longitute'] = 0.00;
        }
    }

    /**
     * @return void
     */
    public function setOpenstreetmapLink()
    {
        $this->openstreetmap_link = "https://www.openstreetmap.org/?mlat={$this->coordinates['latitute']}&mlon={$this->coordinates['longitute']}";
    }

    /**
     * @return void
     */
    public function setPostalCode()
    {
        $this->postalCode = rand(1000, 81000);
    }

    /**
     * @return void
     */
    public function setTimeZone()
    {
        date_default_timezone_set('Europe/Istanbul');
        $this->timeZone = [
            "timeZone" => date_default_timezone_get(),
            "time" => date("H:i:s")
        ];
    }
}

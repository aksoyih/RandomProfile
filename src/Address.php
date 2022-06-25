<?php
namespace Aksoyih\RandomProfile;

class Address{
    private $faker;
    private $data;
    private $helper;

    public $fullAddress;
    public $city;
    public $district;
    public $street;
    public $apartmentNumber;
    public $postalCode;
    public $timeZone;
    public $coordinates;
    public $openstreetmap_link;

    public function __construct(\Faker\Generator $faker)
    {
        $this->faker = $faker;
        $this->helper = new Helper();

        $this->loadData();

        $this->setFullAddress();

        $this->setPostalCode();
        $this->setTimeZone();
    }

    public function loadData(){
        $address_data = $this->helper->getAddressData();
        $random_address_index = array_rand($address_data);
        $this->data = $address_data[$random_address_index];
    }

    public function setFullAddress(){
        $this->setCity();
        $this->setStreet();
        $this->setDistrict();
        $this->setapartmentNumber();
        $this->setCoordinates($this->city);
        $this->setOpenstreetmapLink();

        $this->fullAddress = "{$this->street} {$this->district} {$this->apartmentNumber} / {$this->postalCode} {$this->city}";
    }

    public function setStreet(){
        $this->street = $this->helper->ucfirst($this->helper->strtolower($this->data[0]), 'UTF-8');
    }

    public function setDistrict(){
        $this->district = $this->helper->ucfirst($this->helper->strtolower($this->data[1]), 'UTF-8');
    }

    public function setCity(){
        $this->city = $this->helper->ucfirst($this->helper->strtolower($this->data[2]), 'UTF-8');
    }

    public function setapartmentNumber(){
        $this->apartmentNumber = rand(1,99);
    }

    public function setPostalCode(){
        $this->postalCode = rand(1000,81000);
    }

    public function setTimeZone(){
        date_default_timezone_set('Europe/Istanbul');
        $this->timeZone = [
            "timeZone" => date_default_timezone_get(),
            "time" => date("H:i:s")
        ];
    }

    public function setCoordinates($city){
        $coordinateData = $this->helper->getCoordinateData();

        if(isset($coordinateData[$city])){
            $this->coordinates['latitute'] = $coordinateData[$city][0];
            $this->coordinates['longitute'] = $coordinateData[$city][1];
        }else{
            $this->coordinates['latitute'] = 0.00;
            $this->coordinates['longitute'] = 0.00;
        }
    }

    public function setOpenstreetmapLink()
    {
        $this->openstreetmap_link = "https://www.openstreetmap.org/?mlat={$this->coordinates['latitute']}&mlon={$this->coordinates['longitute']}";
    }
}

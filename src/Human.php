<?php
namespace Aksoyih\RandomProfile;

class Human{
    private $faker;
    private $gender;

    public $name;
    public $surname;
    public $birthdate;

    public function __construct(\Faker\Generator $faker, $gender)
    {
        $this->faker = $faker;
        $this->gender = $gender;

        $this->getName();
        $this->getSurname();
        $this->getBirthdate();
    }

    public function getName(){
        $this->name = $this->faker->name($this->gender);
    }

    public function getSurname(){
        $this->surname = $this->faker->lastName($this->gender);
    }

    public function getBirthdate()
    {
        $this->birthdate = $this->faker->dateTimeBetween('1940-01-01', date("Y-m-d"))->format("Y-m-d");
    }
}

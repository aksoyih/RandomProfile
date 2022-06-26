<?php

namespace Aksoyih\RandomProfile;

use Faker\Factory;
use Faker\Generator;

class Profile
{
    /**
     * @var
     */
    public $profile;
    /**
     * @var Generator
     */
    private $faker;
    /**
     * @var mixed|null
     */
    private $gender;
    /**
     * @var
     */
    private $numberOfProfiles;

    public function __construct()
    {
        $this->faker = Factory::create("tr_TR");
        $this->gender = null;
        $this->setNumberOfProfiles(1);
    }

    /**
     * @param $numberOfProfiles Int
     * @return void
     */
    public function setNumberOfProfiles(int $numberOfProfiles)
    {
        if(!is_int($numberOfProfiles)){
            throw new \Error("setNumberOfProfiles method expects an integer as its only parameter", 1001);
        }

        $this->numberOfProfiles = $numberOfProfiles;
    }

    /**
     * @param $gender String
     * @return void
     */
    public function setGender(string $gender)
    {
        if(!in_array($gender, ["male", "female"])){
            throw new \Error("setGender method expects either male or female as its only parameter", 1002);
        }

        $this->gender = $gender;
    }

    /**
     * @return void
     */
    public function createProfiles()
    {
        for ($i = 1; $i <= $this->numberOfProfiles; $i++) {
            if (is_null($this->gender)) {
                $this->gender = $this->faker->randomElement(['male', 'female']);
            }

            $this->profile[] = new Human($this->faker, $this->gender);
        }
    }

    /**
     * @return mixed
     */
    public function getProfiles()
    {
        return $this->profile;
    }
}
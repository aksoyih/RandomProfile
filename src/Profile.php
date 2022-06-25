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

    /**
     * @param $locale
     * @param $gender
     */
    public function __construct($locale = "tr_TR", $gender = null)
    {
        $this->faker = Factory::create($locale);
        $this->gender = $gender;
        $this->setNumberOfProfiles(1);
    }

    /**
     * @param $numberOfProfiles
     * @return void
     */
    public function setNumberOfProfiles($numberOfProfiles)
    {
        $this->numberOfProfiles = $numberOfProfiles;
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
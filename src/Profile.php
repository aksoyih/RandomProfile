<?php
namespace Aksoyih\RandomProfile;

class Profile
{
	private $faker;
    private $gender;
    private $numberOfProfiles;

    public $profile;
	public function __construct($locale = "tr_TR", $gender = null)
	{
        $this->faker = \Faker\Factory::create($locale);
        $this->gender = $gender;
        $this->setNumberOfProfiles(1);
	}

    public function createProfiles(){
        for($i = 1; $i <= $this->numberOfProfiles; $i++){
            if(is_null($this->gender)) {
                $this->gender = $this->faker->randomElement(['male', 'female']);
            }

            $this->profile[] = new Human($this->faker, $this->gender);
        }
    }

    public function getProfiles(){
        return $this->profile;
    }

    public function setNumberOfProfiles($numberOfProfiles){
        $this->numberOfProfiles = $numberOfProfiles;
    }
}
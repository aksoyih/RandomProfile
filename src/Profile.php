<?php
namespace Aksoyih\RandomProfile;

class Profile
{
	private $faker;
    private $gender;

    public $human;
	public function __construct($locale = "tr_TR", $gender = "unisex")
	{
        $this->faker = \Faker\Factory::create($locale);
        $this->gender = $gender;

        $this->human = new Human($this->faker, $this->gender);
	}

    public function json(){
        return json_encode($this, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
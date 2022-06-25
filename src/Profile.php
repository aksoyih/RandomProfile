<?php
namespace Aksoyih\RandomProfile;

class Profile
{
	private $faker;

	public function __construct($locale = "tr_TR")
	{
        $this->faker = \Faker\Factory::create($locale);
	}
}
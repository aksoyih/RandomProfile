<?php

namespace Aksoyih\RandomProfile;

use Faker\Generator;

class Image
{
    public $avatar;
    public $profile_picture;
    public $pixel_art;
    /**
     * @var Generator
     */
    private $faker;
    /**
     * @var
     */
    private $gender;
    /**
     * @var string
     */
    private $xgames_url;

    /**
     * @param Generator $faker
     * @param $gender
     */
    public function __construct(Generator $faker, $gender)
    {
        $this->faker = $faker;
        $this->gender = $gender;
        $this->xgames_url = "https://xsgames.co/randomusers/avatar.php";
        $this->setAvatar();
        $this->setProfilePicture();
        $this->setPixelArt();
    }

    /**
     * @return void
     */
    public function setAvatar()
    {
        $this->avatar = "https://avatars.dicebear.com/api/personas/{$this->faker->userName}.jpg";
    }

    /**
     * @return void
     */
    public function setProfilePicture()
    {
        $this->profile_picture = "{$this->xgames_url}?g={$this->gender}";
    }

    /**
     * @return void
     */
    public function setPixelArt()
    {
        $this->pixel_art = "{$this->xgames_url}?g=pixel";
    }
}
<?php
namespace Aksoyih\RandomProfile;

class Image{
    private $faker;
    private $gender;

    public $avatar;
    public $profile_picture;
    public $pixel_art;

    public function __construct(\Faker\Generator $faker, $gender)
    {
        $this->faker = $faker;
        $this->gender = $gender;

        $this->setAvatar();
        $this->setProfilePicture();
        $this->setPixelArt();
    }

    public function setAvatar(){
        $this->avatar = "https://avatars.dicebear.com/api/personas/{$this->faker->userName}.jpg";
    }

    public function setProfilePicture(){
        $this->profile_picture = "https://xsgames.co/randomusers/avatar.php?g={$this->gender}";
    }

    public function setPixelArt(){
        $this->pixel_art = "https://xsgames.co/randomusers/avatar.php?g=pixel";
    }
}
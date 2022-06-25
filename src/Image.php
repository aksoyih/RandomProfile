<?php
namespace Aksoyih\RandomProfile;

class Image{
    private $faker;
    private $gender;
    private $xgames_url;

    public $avatar;
    public $profile_picture;
    public $pixel_art;

    public function __construct(\Faker\Generator $faker, $gender)
    {
        $this->faker = $faker;
        $this->gender = $gender;
        $this->xgames_url = "https://xsgames.co/randomusers/avatar.php";
        $this->setAvatar();
        $this->setProfilePicture();
        $this->setPixelArt();
    }

    public function setAvatar(){
        $this->avatar = "https://avatars.dicebear.com/api/personas/{$this->faker->userName}.jpg";
    }

    public function setProfilePicture(){
        $this->profile_picture = "{$this->xgames_url}?g={$this->gender}";
    }

    public function setPixelArt(){
        $this->pixel_art = "{$this->xgames_url}?g=pixel";
    }
}
<?php
namespace Aksoyih\RandomProfile;

class Human{
    private $faker;
    private $helper;

    public $gender;
    public $name;
    public $surname;
    public $birthdate;
    public $age;
    public $titles;
    public $email;
    public $phone;
    public $loginCredentials;
    public $miscellaneous;
    public $networkInfo;

    public $address;
    public $images;

    public function __construct(\Faker\Generator $faker, $gender)
    {
        $this->faker = $faker;
        $this->gender = $gender;

        $this->address = new Address($this->faker);
        $this->images = new Image($this->faker, $this->gender);
        $this->helper = new Helper();

        $this->setName();
        $this->setSurname();
        $this->setBirthdate();
        $this->setTitles();
        $this->setEmail();
        $this->setPhone();
        $this->setLoginCredentials();
        $this->setMiscellaneous();
        $this->setNetworkInfo();
    }

    public function setName(){
        $this->name = $this->faker->firstName($this->gender);
    }

    public function setSurname(){
        $this->surname = $this->faker->lastName($this->gender);
    }

    public function setBirthdate()
    {
        $this->birthdate = $this->faker->dateTimeBetween('1940-01-01', date("Y-m-d"))->format("Y-m-d");
        $this->age = floor((time() - strtotime($this->birthdate)) / 31556926);
    }

    public function setTitles(){
        $this->titles['academic_title'] = null;

        if(rand(1,10) == 1) {
            $this->titles['academic_title'] = $this->faker->title($this->gender);
        }
    }

    public function setEmail(){
        $email_domain = ["example.com"];

        switch (rand(1,7)) {
            case 1:
                $email = strtolower($this->helper->replace_tr("{$this->name}.{$this->surname}@{$this->faker->randomElement($email_domain)}"));
                break;
            case 2:
                $email = strtolower($this->helper->replace_tr("{$this->name}.{$this->surname}.{$this->address->city}@{$this->faker->randomElement($email_domain)}"));
                break;
            case 3:
                $email = strtolower($this->helper->replace_tr("{$this->name}_{$this->address->city}@{$this->faker->randomElement($email_domain)}"));
                break;
            case 4:
                $email = strtolower($this->helper->replace_tr("{$this->surname}_{$this->name}@{$this->faker->randomElement($email_domain)}"));
                break;
            case 5:
                $email = strtolower($this->helper->replace_tr("{$this->surname}_{$this->address->city}@{$this->faker->randomElement($email_domain)}"));
                break;
            case 6:
                $email = strtolower($this->helper->replace_tr("{$this->name}-{$this->address->city}@{$this->faker->randomElement($email_domain)}"));
                break;
            default:
                $email = strtolower($this->helper->replace_tr("{$this->address->city}_{$this->name}_{$this->address->city}@{$this->faker->randomElement($email_domain)}"));
        }

        $this->email = $email;
    }

    public function setLoginCredentials()
    {
        $this->loginCredentials['username'] = $this->createUsername();
        $this->loginCredentials['email'] = $this->email;
        $this->loginCredentials['password'] = $this->faker->password(8);
        $this->loginCredentials['salt'] = $this->faker->password(25);
        $this->loginCredentials['hash'] = $this->faker->password(25);
        $this->loginCredentials['md5'] = md5($this->loginCredentials['password']);
        $this->loginCredentials['sha1'] = sha1($this->loginCredentials['password']);
        $this->loginCredentials['sha256'] = password_hash($this->loginCredentials['password'], PASSWORD_DEFAULT);
        $this->loginCredentials['created_at'] = $this->faker->dateTimeBetween('-3 years', 'now')->format("Y-m-d H:i:s");
        $this->loginCredentials['updated_at'] = null;
        if (rand(1, 3) == 1) {
            $this->loginCredentials['updated_at'] = $this->faker->dateTimeBetween('-3 years', 'now')->format("Y-m-d H:i:s");
        }
    }

    public function setPhone(){
        $this->phone['number'] = $this->faker->phoneNumber;
        $this->phone['imei'] = $this->faker->imei;
    }

    public function setMiscellaneous(){
        for($i = 1; $i <= rand(1,4); $i++){
            $this->miscellaneous['favorite_emojis'][] = $this->faker->emoji;
        }

        $this->miscellaneous['language_code'] = $this->faker->languageCode;
        $this->miscellaneous['country_code'] = $this->faker->countryCode;
        $this->miscellaneous['locale_data'] = $this->faker->locale;
        $this->miscellaneous['currency_code'] = $this->faker->currencyCode;
    }

    public function setNetworkInfo(){
        $this->networkInfo['ipv_4'] = $this->faker->ipv4;
        $this->networkInfo['ipv_6'] = $this->faker->ipv6;
        $this->networkInfo['mac_address'] = $this->faker->macAddress;
    }
    private function createUsername(): string
    {
        switch (rand(1,7)) {
            case 1:
                $username = strtolower($this->helper->replace_tr("{$this->name}{$this->surname}"));
                break;
            case 2:
                $username = strtolower($this->helper->replace_tr("{$this->name}{$this->surname}.{$this->address->city}"));
                break;
            case 3:
                $username = strtolower($this->helper->replace_tr("{$this->name}_{$this->address->city}".rand(1,99)));
                break;
            case 4:
                $username = strtolower($this->helper->replace_tr("{$this->surname}_{$this->name}"));
                break;
            case 5:
                $username = strtolower($this->helper->replace_tr("{$this->surname}_{$this->address->city}".rand(1,99)));
                break;
            case 6:
                $username = strtolower($this->helper->replace_tr("{$this->name}-{$this->address->city}"));
                break;
            default:
                $username = strtolower($this->helper->replace_tr("{$this->address->city}_{$this->name}".rand(1,99)));
        }

        return $username;
    }
}

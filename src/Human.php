<?php
namespace Aksoyih\RandomProfile;

class Human{
    private $faker;

    public $gender;
    public $name;
    public $surname;
    public $birthdate;
    public $age;
    public $titles;
    public $email;
    public $loginCredentials;

    public $address;

    public function __construct(\Faker\Generator $faker, $gender)
    {
        $this->faker = $faker;
        $this->gender = $gender;
        $this->address = new Address($this->faker);

        $this->setName();
        $this->setSurname();
        $this->setBirthdate();
        $this->setTitles();
        $this->setEmail();
        $this->setLoginCredentials();
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
                $email = strtolower($this->replace_tr("{$this->name}.{$this->surname}@{$this->faker->randomElement($email_domain)}"));
                break;
            case 2:
                $email = strtolower($this->replace_tr("{$this->name}.{$this->surname}.{$this->address->city}@{$this->faker->randomElement($email_domain)}"));
                break;
            case 3:
                $email = strtolower($this->replace_tr("{$this->name}_{$this->address->city}@{$this->faker->randomElement($email_domain)}"));
                break;
            case 4:
                $email = strtolower($this->replace_tr("{$this->surname}_{$this->name}@{$this->faker->randomElement($email_domain)}"));
                break;
            case 5:
                $email = strtolower($this->replace_tr("{$this->surname}_{$this->address->city}@{$this->faker->randomElement($email_domain)}"));
                break;
            case 6:
                $email = strtolower($this->replace_tr("{$this->name}-{$this->address->city}@{$this->faker->randomElement($email_domain)}"));
                break;
            default:
                $email = strtolower($this->replace_tr("{$this->address->city}_{$this->name}_{$this->address->city}@{$this->faker->randomElement($email_domain)}"));
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

    public function createUsername(): string
    {
        switch (rand(1,7)) {
            case 1:
                $username = strtolower($this->replace_tr("{$this->name}{$this->surname}"));
                break;
            case 2:
                $username = strtolower($this->replace_tr("{$this->name}{$this->surname}.{$this->address->city}"));
                break;
            case 3:
                $username = strtolower($this->replace_tr("{$this->name}_{$this->address->city}".rand(1,99)));
                break;
            case 4:
                $username = strtolower($this->replace_tr("{$this->surname}_{$this->name}"));
                break;
            case 5:
                $username = strtolower($this->replace_tr("{$this->surname}_{$this->address->city}".rand(1,99)));
                break;
            case 6:
                $username = strtolower($this->replace_tr("{$this->name}-{$this->address->city}"));
                break;
            default:
                $username = strtolower($this->replace_tr("{$this->address->city}_{$this->name}".rand(1,99)));
        }

        return $username;
    }

    private function replace_tr($text) { //kudos: https://www.kodevreni.com/639-php-t%C3%BCrk%C3%A7e-karakterleri-ingilizceye-d%C3%B6n%C3%BC%C5%9Ft%C3%BCrme/
        $text = trim($text);
        $search = array('Ç','ç','Ğ','ğ','ı','İ','Ö','ö','Ş','ş','Ü','ü',' ');
        $replace = array('c','c','g','g','i','i','o','o','s','s','u','u','-');
        return str_replace($search,$replace,$text);
    }
}

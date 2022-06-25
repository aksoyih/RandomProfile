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
    public $maritalInfo;
    public $children;

    public $address;
    public $images;

    public function __construct(\Faker\Generator $faker, $gender, $child = false)
    {
        $this->faker = $faker;
        $this->gender = $gender;

        $this->helper = new Helper();

        $this->address = new Address($this->faker);

        $this->setName();
        $this->setSurname();
        $this->setBirthdate();
        $this->setEmail();
        $this->setPhone();
        $this->setTitles();

        if(!$child){
            $this->images = new Image($this->faker, $this->gender);

            $this->setLoginCredentials();
            $this->setMiscellaneous();
            $this->setNetworkInfo();
            $this->setMaritalInfo();
            $this->setChildren();
        }
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
        $this->phone['device_operation_system'] = $this->faker->randomElement(["Android", "iOS"]);
        if($this->phone['device_operation_system'] == "iOS"){
            $this->phone['device'] = $this->faker->randomElement(["Apple iPhone 11", "Apple iPhone SE 2020", "Apple iPhone XR", "Apple iPhone 12", "Apple iPhone 8"]);
        }else{
            $this->phone['device'] = $this->faker->randomElement(["Google Pixel 2", "Samsung Galaxy S21 Ultra 5G", "Samsung Galaxy S20 Ultra", "Samsung Galaxy S20", "Samsung Galaxy S20+", "Samsung Galaxy A32 5G", "Samsung Galaxy S9"]);
        }
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

    public function setMaritalInfo(){
        $this->maritalInfo['status'] = $this->faker->randomElement(["married", "single", "divorced", "widowed"]);

        if($this->age < 18){
            $this->maritalInfo['status'] = "single";
        }

        if($this->maritalInfo['status'] == "married"){
            if($this->gender == "male") $spouse_gender = "female"; else $spouse_gender = "male";
            $spouse = new Human($this->faker, $spouse_gender, true);

            if($spouse->age < 18){
                $spouse->birthdate = $this->faker->dateTimeBetween($this->birthdate, "-18 years")->format("Y-m-d");
                $spouse->age = floor((time() - strtotime($spouse->birthdate)) / 31556926);
            }

            $spouse->surname = $this->surname;

            unset($spouse->titles, $spouse->loginCredentials, $spouse->miscellaneous, $spouse->networkInfo, $spouse->maritalInfo, $spouse->children, $spouse->images, $spouse->address);
            $youngest_date = date("Y-m-d", min(strtotime($this->birthdate), strtotime($spouse->birthdate)));

            $this->maritalInfo['marriage_date'] = $this->faker->dateTimeBetween(date("{$youngest_date} + 18 years"), 'now')->format("Y-m-d");
            $this->maritalInfo['marriedFor'] = floor((time() - strtotime($this->maritalInfo['marriage_date'])) / 31556926);

            $this->maritalInfo['spouse'] = $spouse;
        }elseif ($this->maritalInfo['status'] == "divorced" || $this->maritalInfo['status'] == "widowed") {
            $this->maritalInfo['marriage_date'] = $this->faker->dateTimeBetween(date("{$this->birthdate} + 18 years"), 'now')->format("Y-m-d");
            $this->maritalInfo['divorce_date'] = $this->faker->dateTimeBetween(date("{$this->maritalInfo['marriage_date']}"), 'now')->format("Y-m-d");
            $this->maritalInfo['marriedFor'] = floor((time() - strtotime($this->maritalInfo['divorce_date'])) / 31556926);
        }
    }

    public function setChildren(){
        if($this->maritalInfo['status'] != "single"){
            if(strtotime($this->maritalInfo['marriage_date']) > strtotime("-9 months")) {
                $this->children['count'] = 0;
            }else{
                $this->children['count'] = rand(0, rand(1, 3));
            }
        }else{
            $this->children['count'] = 0;
        }

        if($this->children['count'] > 0){
            for($i = 1; $i<=$this->children['count']; $i++){
                $child = new Human($this->faker, $this->faker->randomElement(["male","female"]), true);
                $child->surname = $this->surname;

                $child->birthdate = $this->faker->dateTimeBetween("{$this->maritalInfo['marriage_date']}", 'now')->format("Y-m-d");

                if($this->maritalInfo['status'] == "divorced" || $this->maritalInfo['status'] == "widowed"){
                    $child->birthdate = $this->faker->dateTimeBetween("{$this->maritalInfo['marriage_date']}", "{$this->maritalInfo['divorce_date']}")->format("Y-m-d");
                }

                if($child->age <= 18){
                    $child->address = $this->address;
                }

                $child->age = floor((time() - strtotime($child->birthdate)) / 31556926);

                unset($child->titles, $child->loginCredentials, $child->miscellaneous, $child->networkInfo, $child->maritalInfo, $child->children, $child->images);
                $this->children['children'][] = $child;
            }
        }
    }
}

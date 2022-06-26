<?php

namespace Aksoyih\RandomProfile;

use Faker\Generator;

class Job
{
    private $faker;

    /**
     * @var string
     */
    public $workingStatus;
    /**
     * @var
     */
    public $company;
    /**
     * @var
     */
    public $position;
    /**
     * @var
     */
    public $startDate;
    /**
     * @var
     */
    public $endDate;
    /**
     * @var
     */
    public $experience;
    /**
     * @var
     */
    public $salary;

    public function __construct(Generator $faker, $age)
    {
        $this->faker = $faker;
        $this->workingStatus = 'not working';

        if($this->faker->boolean(85) && $age >= 18) {
            $this->workingStatus = 'working';
            $this->setCompany();
            $this->setPosition();
            $this->setDates();
            $this->setSalary();
        }else{
            if($age >= 18 && $this->faker->boolean(60)) {
                $this->setDates();
            }
        }
    }

    /**
     * @return void
     */
    public function setCompany()
    {
        $this->company = $this->faker->company;
    }

    /**
     * @return void
     */
    public function setPosition()
    {
        $this->position = $this->faker->jobTitle;
    }

    /**
     * @return void
     */
    public function setStartDate()
    {
        $this->startDate = $this->faker->dateTimeBetween('now -18 year', 'now')->format('Y-m-d');
    }

    /**
     * @return void
     */
    public function setEndDate()
    {
        $this->endDate = null;

        if($this->faker->boolean(15) || $this->workingStatus != 'working') {
            $this->endDate = $this->faker->dateTimeBetween($this->startDate, 'now')->format('Y-m-d');
        }
    }

    /**
     * @return void
     */
    public function setExperience()
    {
        $end_date = $this->endDate ?: 'now';
        $this->experience = floor((strtotime($end_date) - strtotime($this->startDate)) / 31556926);
    }

    /**
     * @return void
     */
    private function setDates(){
        $this->setStartDate();
        $this->setEndDate();
        $this->setExperience();
    }

    /**
     * @return void
     */
    public function setSalary(){
        $this->salary['monthly'] = (float)number_format($this->faker->randomFloat(2, 0, 4500) * ($this->experience/2), 2, '.', '');
        $this->salary['annually'] = (float)number_format($this->salary['monthly'] * 12, 2, '.', '');
    }
}
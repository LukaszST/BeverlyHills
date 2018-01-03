<?php

namespace Test\BeverlyHills;

use BeverlyHills\Customer;
use BeverlyHills\Movie;
use BeverlyHills\Rental;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    public function testStatement_oneDayRentalOfNewRelease()
    {
        $customer = new Customer('Joe');
        $customer->addRental($this->createRental('Star Wars', Movie::NEW_RELEASE, 1));

        $ret = $customer->statement();

        $this->assertContains("Star Wars\t3\n", $ret);
        $this->assertContains("Amount owned is 3\n", $ret);
        $this->assertContains("You earned 1 frequent renter points", $ret);
    }

    public function testStatement_threeDayRentalOfNewRelease()
    {
        $customer = new Customer('Joe');
        $customer->addRental($this->createRental('Star Wars', Movie::NEW_RELEASE, 3));

        $ret = $customer->statement();

        $this->assertContains("Star Wars\t9\n", $ret);
        $this->assertContains("Amount owned is 9\n", $ret);
        $this->assertContains("You earned 2 frequent renter points", $ret);
    }

    public function testStatement_oneDayRentalOfRegular()
    {
        $customer = new Customer('Joe');
        $customer->addRental($this->createRental('Enter the Dragon', Movie::REGULAR, 1));

        $ret = $customer->statement();

        $this->assertContains("Enter the Dragon\t2\n", $ret);
        $this->assertContains("Amount owned is 2\n", $ret);
        $this->assertContains("You earned 1 frequent renter points", $ret);
    }

    public function testStatement_threeDayRentalOfRegular()
    {
        $customer = new Customer('Joe');
        $customer->addRental($this->createRental('Enter the Dragon', Movie::REGULAR, 3));

        $ret = $customer->statement();

        $this->assertContains("Enter the Dragon\t3.5\n", $ret);
        $this->assertContains("Amount owned is 3.5\n", $ret);
        $this->assertContains("You earned 1 frequent renter points", $ret);
    }

    public function testStatement_oneDayRentalOfChildrensType()
    {
        $customer = new Customer('Joe');
        $customer->addRental($this->createRental('Nemo', Movie::CHILDRENS, 1));

        $ret = $customer->statement();

        $this->assertContains("Nemo\t1.5\n", $ret);
        $this->assertContains("Amount owned is 1.5\n", $ret);
        $this->assertContains("You earned 1 frequent renter points", $ret);
    }

    public function testStatement_fourDayRentalOfChildrensType()
    {
        $customer = new Customer('Joe');
        $customer->addRental($this->createRental('Nemo', Movie::CHILDRENS, 4));

        $ret = $customer->statement();

        $this->assertContains("Nemo\t3\n", $ret);
        $this->assertContains("Amount owned is 3\n", $ret);
        $this->assertContains("You earned 1 frequent renter points", $ret);
    }

    public function testStatement_threeRentalTypes()
    {
        $customer = new Customer('Joe');
        $customer->addRental($this->createRental('Enter the Dragon', Movie::REGULAR, 1));
        $customer->addRental($this->createRental('Star Wars', Movie::NEW_RELEASE, 1));
        $customer->addRental($this->createRental('Nemo', Movie::CHILDRENS, 1));

        $ret = $customer->statement();

        $this->assertContains("Star Wars\t3\n", $ret);
        $this->assertContains("Enter the Dragon\t2\n", $ret);
        $this->assertContains("Nemo\t1.5\n", $ret);
        $this->assertContains("Amount owned is 6.5\n", $ret);
        $this->assertContains("You earned 3 frequent renter points", $ret);
    }

    private function createRental(string $name, string $priceCode, int $daysRent): Rental
    {
        return new Rental (new Movie($name, $priceCode), $daysRent);
    }
}

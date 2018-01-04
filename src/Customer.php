<?php
declare(strict_types=1);

namespace BeverlyHills;

class Customer
{
    private $name;
    private $rentals = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function addRental(Rental $rental): void
    {
        $this->rentals[] = $rental;
    }

    public function getName()
    {
        return $this->name;
    }

    public function statement(): string
    {
        $totalAmount = 0;
        $frequentRenterPoints = 0;
        $result = "Rental Record for " . $this->getName() . "\n";

        /** @var Rental $each */
        foreach ($this->rentals as $each) {
            $thisAmount = 0;

            $thisAmount = $this->amountFor($each);

            $frequentRenterPoints++;
            if (($each->getMovie()->getPriceCode() == Movie::NEW_RELEASE)
                && $each->getDaysRented() > 1
            ) {
                $frequentRenterPoints ++;
            }
            $result .= $each->getMovie()->getTitle() . "\t" . $thisAmount . "\n";
            $totalAmount += $thisAmount;
        }
        $result .= "Amount owned is " . $totalAmount . "\n";
        $result .= "You earned " . $frequentRenterPoints . " frequent renter points";

        return $result;
    }

    public function amountFor(Rental $aRental): float
    {
        return $aRental->getCharge();
    }
}
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

        /** @var Rental $rental */
        foreach ($this->rentals as $rental) {
            $frequentRenterPoints++;
            if (($rental->getMovie()->getPriceCode() == Movie::NEW_RELEASE)
                && $rental->getDaysRented() > 1
            ) {
                $frequentRenterPoints ++;
            }
            $result .= $rental->getMovie()->getTitle() . "\t" . $rental->getCharge() . "\n";
            $totalAmount += $rental->getCharge();
        }
        $result .= "Amount owned is " . $totalAmount . "\n";
        $result .= "You earned " . $frequentRenterPoints . " frequent renter points";

        return $result;
    }
}
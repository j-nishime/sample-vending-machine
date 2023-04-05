<?php

namespace App\UseCase;

require(realpath(dirname(__FILE__).'/../../vendor/autoload.php'));
use App\Domain\VendingMachine;

class BuyDrinkUseCase
{
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function execute(
        array $coins,
        string $menu,
        array $vendingMachineCoins = [
            '500' => 999,
            '100' => 999,
            '50' => 999,
            '10' => 999,
        ]
    ): string
    {
        $vendingMachine = new VendingMachine($vendingMachineCoins);
        $vendingMachine->receiveCoin($coins);
        $vendingMachine->selectMenu($menu);
        $change = $vendingMachine->returnChange();
        return $change->toString();
    }
}
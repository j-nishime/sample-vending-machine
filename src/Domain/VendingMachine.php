<?php

namespace Domain;

class VendingMachine
{
    private int $payment;
    private string $selectedMenu;
    private array $menu = [
        'cola' => 120,
        'coffee' => 150,
        'energy_drink' => 210
    ];

    public function __construct(readonly private array $ownCoins)
    {
    }

    /**
     * @return void
     */
    public function receiveCoin(array $coins): void
    {
        $keys = array_keys($coins);
        $total = 0;
        foreach ($coins as $coin => $amount) {
            $total += (int) $coin * $amount;
        }
        $this->payment = $total;
    }

    /**
     * @return void
     */
    public function selectMenu(string $menu): void
    {
        $this->selectedMenu = $menu;
    }

    /**
     * @return array
     */
    public function returnChange(): array
    {
        $price = $this->menu[$this->selectedMenu];
        $change = $this->payment - $price;
        return $this->getChangeToCoins($change);
    }

    /**
     * @return array
     */
    public function getChangeToCoins(int $change): array
    {
        // お釣りが0円なら空配列を返す
        if ($change === 0) {
            return [];
        }
        $defaultCoins = array(500, 100, 50, 10);
        $changeCoins = [];
        foreach($defaultCoins as $coin){
            $res = $change / $coin;
            $amount = floor($res);
            $key = (String) $coin;
            $ownCoin = $this->ownCoins[$key] - $amount;
            $hasCoin = $ownCoin > 0;
            if (!$hasCoin) {
                // 釣り銭がない時はターゲットの硬貨は0枚にする
                $changeCoins[$coin] = 0;
            } else {
                // 釣り銭がある時は返せるだけ返して差し引いたお釣りを次のループで計算する
                $changeCoins[$coin] = $amount;
                $change = $change - ($coin * $amount);
            }
        }
        return $changeCoins;
    }
}
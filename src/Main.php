<?php

declare(strict_types=1);

/**
 * メインクラス。
 * 原則ここにロジックは書かないこと。
 */
class Main
{
    /**
     * 処理の開始地点
     *
     * @param array $coins 投入額
     * @param string $order 注文
     * @return string おつり。大きな硬貨順に枚数を並べる。なしの場合はnochange
     * ex.)
     * - 100円3枚、50円1枚、10円3枚なら"100 3 50 1 10 3"
     */
    public static function runSimply(array $coins, string $order): string
    {
        $menu = array(
            'cola' => 120,
            'coffee' => 150,
            'energy_drink' => 210
        );
        $price = $menu[$order];
        $money = self::getTotalMoney($coins);
        $change = $money - $price;
        $changeCoins = self::getChangeCoins($change);
        return self::getChangeToString($changeCoins);
    }

    public static function getTotalMoney(array $coins): int {
        $money = 0;
        foreach($coins as $coin => $amount) {
            $money += intval($coin) * $amount;
        }
        return $money;
    }

    public static function getChangeCoins(int $change): array {
        if ($change === 0) {
            return [];
        }
        $defaultCoins = array(500, 100, 50, 10);
        $changeCoins = [];
        foreach($defaultCoins as $coin){
            $res = $change / $coin;
            $amount = floor($res);
            $changeCoins[$coin] = $amount;
            $change = $change - ($coin * $amount);
        }
        return $changeCoins;
    }

    public static function getChangeToString(array $changeCoins): string {
        $changeToString = "";
        foreach($changeCoins as $coin => $amount){
            if ($amount > 0) {
                if ($changeToString !== ""){
                    $changeToString .= " ";
                }
                $changeToString .= "{$coin} {$amount}";
            }
        }
        if ($changeToString === "") {
            return "nochange";
        }
        return $changeToString;
    }

    /**
     * 処理の開始地点。ただし自動販売機がいくつ硬貨を持っているかも合わせて処理する
     *
     * @param array $vendingMachineCoins 自販機に補充される硬貨
     * @param array $userInput 投入額と注文。前述の$coinsと$menuをあわせたもの
     * @return string おつり。大きな硬貨順に枚数を並べる。なしの場合はnochange
     * ex.)
     * - 100円3枚、50円1枚、10円3枚なら"100 3 50 1 10 3"
     */
    public static function run(array $vendingMachineCoins, array $userInput): string
    {
        $coins = $userInput['coins'];
        $order = $userInput['menu'];
        $menu = array(
            'cola' => 120,
            'coffee' => 150,
            'energy_drink' => 210
        );
        $price = $menu[$order];
        $money = self::getTotalMoney($coins);
        $change = $money - $price;
        return self::getChangeToString($change);
    }
}

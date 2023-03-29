# sample-vending-machine

## 準備

本PRをclone後、プロジェクト直下で下記を実行。

```shell
composer install
```

composerが入ってない方はプロジェクト直下で下記Docker利用したコマンドを実行
```shell
docker run --rm --interactive --tty --volume $PWD:/app composer install
```

## 課題

### 1. もっとも通常のパターン

```shell
# 確認コマンド
docker run --rm --interactive --tty --volume $PWD:/app composer test-round1
```

次の条件が通るように、`runSimply`を修正。

```php
// 100円が1枚、10円が2枚
$coins = [
  '100' => 1,
  '10' => 2,
];

// コーラは120円とする
$menu = 'cola';

// 購入処理
$change = Main::runSimply($coins, $menu);

echo($change); // "nochange" (おつりがない場合)
```

```php
// 100円が2枚
$coins = [
  '100' => 2,
];

// コーラは120円とする
$menu = 'cola';

// 購入処理
$change = Main::runSimply($coins, $menu);

echo($change); // "50 1 10 3" (50円が1枚、10円が3枚)
```

### ２. 自動販売機の硬貨の枚数を考慮するパターン

```shell
# 確認コマンド
docker run --rm --interactive --tty --volume $PWD:/app composer test-round2
```

次の条件が通るように、`run`を修正。

```php
// 自動販売機がもつ硬貨の枚数の状況。50円玉が切れている
$vendingMachineCoins = [
    '500' => 999,
    '100' => 999,
    '50' => 0,
    '10' => 999,
];

// 100円が2枚
$coins = [
  '100' => 2,
];

// コーヒーは150円とする
$menu = 'coffee';

// 投入額と注文をまとめておく
$userInput = [
  "coins" => $coins,
  "menu" => $menu,
];

// 購入処理
$change = Main::run($vendingMachineCoins, $userInput);

echo($change); // "10 5" (50円を1枚返却したいが無いので、10円を5枚返却する)
```


## linter (php-cs-fixer)

プロジェクト直下で`composer lint`を実行。`src`内が勝手にフォーマットされます。


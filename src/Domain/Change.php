<?php

namespace App\Domain;

class Change
{
    public function __construct(readonly private array $coins)
    {
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        $changeToString = "";
        foreach($this->coins as $coin => $amount){
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
}
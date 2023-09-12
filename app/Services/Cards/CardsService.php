<?php

namespace App\Services\Cards;

use App\Models\Card;
use App\Services\ServiceAbstract;

class CardsService extends ServiceAbstract
{
    public function __construct(Card $card)
    {
        parent::__construct($card);
    }
}

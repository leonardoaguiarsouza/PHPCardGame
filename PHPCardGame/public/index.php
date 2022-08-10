<?php

require_once __DIR__ . '/../vendor/autoload.php';

use CardGame\Engine\CardGame;

$cg = new CardGame();

playerTurn($cg->p1, "PLAYER 1");
playerTurn($cg->p2, "PLAYER 2");

function printDeck($cg)
{
    $cardsInDeck = $cg->deck->get();

    echo 'DECK' . PHP_EOL;
    foreach ($cardsInDeck as $key => $card) {
        echo $key . " - " . $card . PHP_EOL;
    }
}

function printHand($cg)
{
    $cardsInHand = $cg->hand->get();
    echo 'HAND' . PHP_EOL;
    foreach ($cardsInHand as $key => $card) {
        echo $key . " - " . $card . PHP_EOL;
    }
}

function playerTurn($player, $pName)
{
    echo '<pre>';
    print_r($pName . ' | HP: ' . $player->getHP() . PHP_EOL);
    printHand($player);
    printDeck($player);
    $overdraw = $player->hand->addCards($player->deck->drawCards(3));
    printHand($player);
    print_r($overdraw);
    printDeck($player);
    $overdraw = $player->hand->addCards($player->deck->drawCards(8));
    printHand($player);
    print_r($overdraw);
    printDeck($player);
    echo '-----------';
    echo '</pre>';
}

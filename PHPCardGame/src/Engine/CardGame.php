<?php declare(strict_types=1);

namespace CardGame\Engine;

class Card
{
    protected int $cost;
    protected int $attack;
    protected int $health;
    protected string $name;
    protected string $description;
    protected string $effect;
}

class Hand
{
    public const MAX_HAND_SIZE = 10;

    protected array $hand = [];

    public function __construct(array $startingHand)
    {
        $this->start($startingHand);
    }

    public function get(): array {
        return $this->hand;
    }

    public function getCurrentSize(): int {
        return count($this->hand);
    }

    public function start($startingHand): void {
        // o retorno é ignorado, pois é impossível dar overdraw na mão inicial
        $this->addCards($startingHand);
    }

    public function addCards(array $cardsToAdd): array {
        $availableHandSpace = self::MAX_HAND_SIZE - ($this->getCurrentSize() + count($cardsToAdd));
        $overdraw = [];

        if ($availableHandSpace < 0) {
            for ($i=$availableHandSpace; $i < 0; $i++)
                $overdraw[] = array_pop($cardsToAdd);
        }

        $this->hand = array_merge($this->hand, $cardsToAdd);

        return [
            "overdraw" => array_reverse($overdraw)
        ];
    }
}

class Deck
{
    public const MAX_DECK_SIZE = 30;

    protected array $deck = [];

    public function __construct()
    {
        $this->start();
    }

    public function get(): array {
        return $this->deck;
    }

    public function start(): void {

        // gera o deck, TEMPORARIO!
        for ($i=0; $i < self::MAX_DECK_SIZE; $i++) {
            $this->deck[$i] = "Card {$i}";
        }

        $this->shuffle();
    }

    public function drawCards(int $qtyOfCardsToDraw): array {
        $listOfDrewCards = [];
        $fatigue = 1;

        for ($i = 0; $i < $qtyOfCardsToDraw; $i++) {
            $listOfDrewCards[] = array_shift($this->deck);

            // Se o deck estiver vazio, começa a contar as instancias de fatiga
            // TODO implementar os metodos de tomar dano baseado na instancia de fatiga,
            // após implementar os pontos de vida e tomada de dano
            if (is_null($listOfDrewCards[$i])) {
                $listOfDrewCards[$i] = "Fatigue_" . $fatigue;
                $fatigue++;
            }
        }

        return $listOfDrewCards;
    }

    public function shuffle(): void {
        shuffle($this->deck);
    }
}

class Player
{
    public const MAX_HP_VALUE = 30;

    protected string $playerName;
    protected int $currentHP;
    protected array $deckList; // deck do jogador, que irá ser instanciado

    public Deck $deck;
    public Hand $hand;

    public function __construct()
    {
        $this->deck = new Deck();
        $this->hand = new Hand($this->deck->drawCards(CardGame::STARTING_CARDS_TO_DRAW));
        $this->currentHP = self::MAX_HP_VALUE;
    }

    public function getHP() {
        return $this->currentHP;
    }
}

class GameBoard {

}

class CardGame
{
    public const STARTING_CARDS_TO_DRAW = 4;

    public Player $p1;
    public Player $p2;

    public function __construct()
    {
        $this->p1 = new Player();
        $this->p2 = new Player();
    }
}
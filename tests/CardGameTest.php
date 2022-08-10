<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

class CardGameTest extends TestCase
{
    public function testCanDrawCard(): void
    {
        $teste = "Aeee";
        $this->assertEquals('Aeee', $teste);
    }
}
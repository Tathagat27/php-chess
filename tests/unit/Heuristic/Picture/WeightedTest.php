<?php

namespace Chess\Tests\Unit\Heuristic\Picture;

use Chess\Board;
use Chess\Heuristic\Picture\Weighted as WeightedHeuristicPicture;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Opening\Benoni\BenkoGambit;
use Chess\Tests\Sample\Opening\RuyLopez\Exchange as ExchangeRuyLopez;

class WeightedTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $board = new Board;

        $picture = (new WeightedHeuristicPicture($board->getMovetext()))->take();

        $expected = [
            Symbol::WHITE => [
                [0.5, 0.5, 0.5, 0.5, 0.5, 0.5],

            ],
            Symbol::BLACK => [
                [0.5, 0.5, 0.5, 0.5, 0.5, 0.5],
            ],
        ];

        $this->assertEquals($expected, $picture);
    }

    /**
     * @test
     */
    public function w_e4_b_e5()
    {
        $board = new Board;

        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'e5'));

        $picture = (new WeightedHeuristicPicture($board->getMovetext()))->take();

        $expected = [
            Symbol::WHITE => [
                [0.5, 0.5, 0.5, 0.5, 0.5, 0.5],

            ],
            Symbol::BLACK => [
                [0.5, 0.5, 0.5, 0.5, 0.5, 0.5],
            ],
        ];

        $this->assertEquals($expected, $picture);
    }

    /**
     * @test
     */
    public function evaluate_benko_gambit()
    {
        $board = (new BenkoGambit(new Board))->play();

        $evaluation = (new WeightedHeuristicPicture($board->getMovetext()))->evaluate();

        $expected = [
            Symbol::WHITE => 1587.76,
            Symbol::BLACK => 1035.63,
        ];

        $this->assertEquals($expected, $evaluation);
    }
}

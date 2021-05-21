<?php

namespace Chess\Tests\Unit\Heuristic\Picture;

use Chess\Board;
use Chess\Heuristic\HeuristicPicture;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Checkmate\Fool as FoolCheckmate;
use Chess\Tests\Sample\Checkmate\Scholar as ScholarCheckmate;

class SampleTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function weights()
    {
        $heuristicPicture = new HeuristicPicture('');

        $weights = array_values($heuristicPicture->getDimensions());

        $expected = 100;

        $this->assertEquals($expected, array_sum($weights));
    }

    /**
     * @test
     */
    public function start()
    {
        $board = new Board();

        $sample = (new HeuristicPicture($board->getMovetext()))
            ->take()
            ->end();

        $expected = [
            Symbol::WHITE => [ 0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5 ],
            Symbol::BLACK => [ 0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5 ],
        ];

        $this->assertEquals($expected, $sample);
    }

    /**
     * @test
     */
    public function w_e4_b_e5()
    {
        $board = new Board();
        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'e5'));

        $sample = (new HeuristicPicture($board->getMovetext()))
            ->take()
            ->end();

        $expected = [
            Symbol::WHITE => [ 0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5 ],
            Symbol::BLACK => [ 0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5 ],
        ];

        $this->assertEquals($expected, $sample);
    }

    /**
     * @test
     */
    public function fool_checkmate()
    {
        $board = (new FoolCheckmate(new Board()))->play();

        $sample = (new HeuristicPicture($board->getMovetext()))
            ->take()
            ->end();

        $expected = [
            Symbol::WHITE => [ 0, 0, 0.9, 0.2, 0, 0, 0.25, 0.25 ],
            Symbol::BLACK => [ 1, 1, 0, 1, 1, 1, 0.25, 0.25 ],
        ];

        $this->assertEquals($expected, $sample);
    }

    /**
     * @test
     */
    public function scholar_checkmate()
    {
        $board = (new ScholarCheckmate(new Board()))->play();

        $sample = (new HeuristicPicture($board->getMovetext()))
            ->take()
            ->end();

        $expected = [
            Symbol::WHITE => [ 1, 0, 0.07, 0.8, 1, 1, 0, 0 ],
            Symbol::BLACK => [ 0, 1, 0.93, 0.4, 0.4, 0, 0.5, 0.1 ],
        ];

        $this->assertEquals($expected, $sample);
    }
}

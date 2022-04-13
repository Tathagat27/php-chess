<?php

namespace Chess\Evaluation;

use Chess\Board;
use Chess\PGN\AN\Color;
use Chess\PGN\AN\Piece;

class AbsoluteForkEvaluation extends AbstractForkEvaluation
{
    const NAME = 'absolute_fork';

    public function __construct(Board $board)
    {
        parent::__construct($board);

        $this->result = [
            Color::W => 0,
            Color::B => 0,
        ];
    }

    public function eval(): array
    {
        foreach ($this->board->getPieces() as $piece) {
            if ($piece->getId() !== Piece::K) {
                $attackedPieces = $this->attackedPieces($piece);
                if ($this->isKingAttacked($attackedPieces)) {
                    $this->result[$piece->getColor()] = $this->sumValues($piece, $attackedPieces);
                }
            }
        }

        return $this->result;
    }
}

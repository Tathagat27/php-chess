<?php

namespace Chess\Variant\Classical\FEN;

/**
 * Converts a short FEN string into PGN move.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class ShortStrToPgn extends AbstractStrToPgn
{
    protected function find(array $legal): ?string
    {
        foreach ($legal as $key => $val) {
            if (str_starts_with(current($val), $this->toFen)) {
                return key($val);
            }
        }

        return null;
    }
}

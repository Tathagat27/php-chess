<?php

namespace Chess;

use Chess\PGN\AN\Castle;
use Chess\PGN\AN\Color;
use Chess\PGN\AN\Piece;

/**
 * Castle rule.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class CastleRule
{
    const IS_CASTLED = 'isCastled';

    public static array $initialState = [
        Color::W => [
            self::IS_CASTLED => false,
            Castle::SHORT => true,
            Castle::LONG => true,
        ],
        Color::B => [
            self::IS_CASTLED => false,
            Castle::SHORT => true,
            Castle::LONG => true,
        ],
    ];

    /**
     * Castle rule by color.
     *
     * @param string $color
     * @return array
     */
    public static function color(string $color): array
    {
        switch ($color) {
            case Color::W:
                return [
                    Piece::K => [
                        Castle::SHORT => [
                            'sqs' => [
                                'f' => 'f1',
                                'g' => 'g1',
                            ],
                            'sq' => [
                                'current' => 'e1',
                                'next' => 'g1',
                            ],
                        ],
                        Castle::LONG => [
                            'sqs' => [
                                'b' => 'b1',
                                'c' => 'c1',
                                'd' => 'd1',
                            ],
                            'sq' => [
                                'current' => 'e1',
                                'next' => 'c1',
                            ],
                        ],
                    ],
                    Piece::R => [
                        Castle::SHORT => [
                            'sq' => [
                                'current' => 'h1',
                                'next' => 'f1',
                            ],
                        ],
                        Castle::LONG => [
                            'sq' => [
                                'current' => 'a1',
                                'next' => 'd1',
                            ],
                        ],
                    ],
                ];

            case Color::B:
                return [
                    Piece::K => [
                        Castle::SHORT => [
                            'sqs' => [
                                'f' => 'f8',
                                'g' => 'g8',
                            ],
                            'sq' => [
                                'current' => 'e8',
                                'next' => 'g8',
                            ],
                        ],
                        Castle::LONG => [
                            'sqs' => [
                                'b' => 'b8',
                                'c' => 'c8',
                                'd' => 'd8',
                            ],
                            'sq' => [
                                'current' => 'e8',
                                'next' => 'c8',
                            ],
                        ],
                    ],
                    Piece::R => [
                        Castle::SHORT => [
                            'sq' => [
                                'current' => 'h8',
                                'next' => 'f8',
                            ],
                        ],
                        Castle::LONG => [
                            'sq' => [
                                'current' => 'a8',
                                'next' => 'd8',
                            ],
                        ],
                    ],
                ];
        }
    }

    /**
     * Can castle short.
     *
     * @param string $color
     * @param array $castle
     * @param object $space
     * @return bool
     */
    public static function short(string $color, array $castle, object $space): bool
    {
        return $castle[$color][Castle::SHORT] &&
            !(in_array(
                self::color($color)[Piece::K][Castle::SHORT]['sqs']['f'],
                $space->{Color::opp($color)})
             ) &&
            !(in_array(
                self::color($color)[Piece::K][Castle::SHORT]['sqs']['g'],
                $space->{Color::opp($color)})
             );
    }

    /**
     * Can castle long.
     *
     * @param string $color
     * @param array $castle
     * @param object $space
     * @return bool
     */
    public static function long(string $color, array $castle, object $space): bool
    {
        return $castle[$color][Castle::LONG] &&
            !(in_array(
                self::color($color)[Piece::K][Castle::LONG]['sqs']['b'],
                $space->{Color::opp($color)})
             ) &&
            !(in_array(
                self::color($color)[Piece::K][Castle::LONG]['sqs']['c'],
                $space->{Color::opp($color)})
             ) &&
            !(in_array(
                self::color($color)[Piece::K][Castle::LONG]['sqs']['d'],
                $space->{Color::opp($color)})
             );
    }
}

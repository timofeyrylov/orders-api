<?php

namespace OrderListing\thesaurus;

enum ModeThesaurus: string
{
    case All = '';

    case Manual = 'manual';

    case Auto = 'auto';

    /**
     * Получение Id режима
     * @param string $mode
     * @return int|null
     */
    public static function getModeId(string $mode = ''): ?int
    {
        return match (self::tryFrom($mode)) {
            self::Manual => 0,
            self::Auto => 1,
            default => null
        };
    }

    /**
     * Поулчение имени режима
     * @param int $mode
     * @return string
     */
    public static function getModeName(int $mode): string
    {
        return match ($mode) {
            0 => self::Manual->name,
            1 => self::Auto->name
        };
    }
}
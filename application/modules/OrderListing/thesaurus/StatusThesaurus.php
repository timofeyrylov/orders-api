<?php

namespace OrderListing\thesaurus;

enum StatusThesaurus: string
{
    case All = '';

    case Pending = 'pending';

    case InProgress = 'inprogress';

    case Completed = 'completed';

    case Canceled = 'canceled';

    case Error = 'error';

    /**
     * Получение Id статуса
     * @param string $status - Наименование статуса
     * @return int|null
     */
    public static function getStatusId(string $status = ''): ?int
    {
        return match (self::tryFrom($status)) {
            self::Pending => 0,
            self::InProgress => 1,
            self::Completed => 2,
            self::Canceled => 3,
            self::Error => 4,
            default => null
        };
    }

    /**
     * Получение имени статуса по его Id
     * @param int $statusId
     * @return string
     */
    public static function getStatusName(int $statusId): string
    {
        return match ($statusId) {
            0 => self::Pending->getLabel(),
            1 => self::InProgress->getLabel(),
            2 => self::Completed->getLabel(),
            3 => self::Canceled->getLabel(),
            4 => self::Error->getLabel(),
        };
    }

    /**
     * Получение имени статуса
     * @return string
     */
    public function getLabel(): string
    {
        return match ($this) {
            self::All => 'All orders',
            self::Pending => 'Pending',
            self::InProgress => 'In progress',
            self::Completed => 'Completed',
            self::Canceled => 'Canceled',
            self::Error => 'Error'
        };
    }
}
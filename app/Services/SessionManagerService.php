<?php

namespace App\Services;


class SessionManagerService
{
    public const ABTESTS_PREFIX = 'abTests_';

    /**
     * @param int $id
     * @return int|null
     */
    public function getAbTestSessionBy(int $id): ?int
    {
        return session(self::ABTESTS_PREFIX . $id);
    }

    /**
     * @param int $id
     * @param int $variableId
     * @return void
     */
    public function setAbTestSessionBy(int $id, int $variableId): void
    {
        session(self::ABTESTS_PREFIX . $id, $variableId);
    }
}

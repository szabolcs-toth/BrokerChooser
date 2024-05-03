<?php

namespace App\Services\ab;

use App\Exceptions\NoVariablesException;
use App\helpers\Helpers;
use App\Models\AbTests;
use App\Services\SessionManagerService;

class AbTestsService
{
    /**
     * @param int $pk
     * @return AbTests
     */
    public function findByPk(int $pk): AbTests
    {
        return AbTests::findOrFail($pk);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function isRunning(int $id): bool
    {
        $abTest = $this->findByPk($id);

        return !empty($abTest['validFrom']) && empty($abTest['validTo']);
    }

    /**
     * @return AbTests
     */
    public function getRunningTests(): AbTests
    {
        return AbTests::whereNotNull('validFrom')
            ->whereNull('validTo');
    }

    /**
     * @param int $pk
     * @return void
     */
    public function setValidTo(int $pk): void
    {
        $now = Helpers::getNow();

        AbTests::findOrFail($pk)->update([
            'updatedAt' => $now,
            'validTo' => $now
        ]);
    }

    /**
     * @param int $pk
     * @return void
     */
    public function setValidFrom(int $pk): void
    {
        $now = Helpers::getNow();

        AbTests::findOrFail($pk)->update([
            'updatedAt' => $now,
            'validFrom' => $now
        ]);
    }

    /**
     * @param int $id
     * @return int
     * @throws NoVariablesException
     */
    public function getRunningTestById(int $id): int
    {
        $sessionManager = new SessionManagerService();
        $variable = $sessionManager->getAbTestSessionBy($id);

        if (is_null($variable)) {
            $abTestVarService = new AbTestsVariablesService();
            $variables = $abTestVarService->getVariablesByTestId($id)?->toArray();

            if (empty($variables)) {
                throw new NoVariablesException();
            }

            $variable = Helpers::getRandomWeightedElement($abTestVarService->generateVariablesList($variables));

            $sessionManager->setAbTestSessionBy($id, $variable);
        }

        return $variable;
    }
}

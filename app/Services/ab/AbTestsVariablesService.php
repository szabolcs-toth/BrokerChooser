<?php

namespace App\Services\ab;

use App\Models\AbTestVariables;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class AbTestsVariablesService
{
    /**
     * @param int $id
     * @return Collection|null
     */
    public function getVariablesByTestId(int $id): ?Collection
    {
        return AbTestVariables::where('abTestId', $id)?->get();
    }

    /**
     * @param array $variables
     * @return array
     */
    public function generateVariablesList(array $variables): array
    {
        $arr = [];

        foreach ($variables as $item) {
            $key = $item['id'];
            $arr[$key] = $item['ratio'];
        }

        Log::debug('variables', ['arr' => $arr]);

        return $arr;
    }

    /**
     * @param int $id
     * @return void
     */
    public function incById(int $id): void
    {
        AbTestVariables::where('id', $id)?->increment('visitors');
    }
}

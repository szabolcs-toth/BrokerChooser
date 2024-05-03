<?php

namespace App\Services\ab;


use App\Models\AbTests;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AbTestManagerService
{
    public const START = 'start';
    public const STOP = 'stop';

    private AbTests $data;
    private AbTestsService $abTestsService;

    private int $abTestId;
    private string $command;

    /**
     * @param int $abTestId
     * @param string $command
     */
    public function __construct(int $abTestId, string $command)
    {
        $this->abTestId = $abTestId;
        $this->command = $command;

        $this->init();
    }

    /**
     * @return void
     */
    private function init(): void
    {
        $this->abTestsService = new AbTestsService();
    }

    /**
     * @return array
     */
    public function validation(): array
    {
        $validator = Validator::make([
            'abTestId' => $this->abTestId,
            'commandName' => $this->command
        ], [
            'abTestId' => [
                'required',
                'integer',
                'exists:App\Models\AbTests,id'
            ],
            'commandName' => ['required', Rule::in(self::START, self::STOP)],
        ]);

        if ($validator->fails()) {
            return $validator->errors()->all();
        }

        return [];
    }

    /**
     * @return AbTests
     */
    public function getData(): AbTests
    {
        if (empty($this->data)) {
            try {
                $this->data = $this->abTestsService->findByPk($this->abTestId);
            } catch (\Throwable $e) {
                Log::error('Error when load AB test data', ['error' => $e]);
            }
        }

        return $this->data;
    }

    /**
     * @return void
     */
    public function setValidTo(): void
    {
        $this->abTestsService->setValidTo($this->abTestId);
    }

    /**
     * @return void
     */
    public function setValidFrom(): void
    {
        $this->abTestsService->setValidFrom($this->abTestId);
    }

    /**
     * @return bool
     */
    public function isStarted(): bool
    {
        return !empty($this->data['validFrom']);
    }

    /**
     * @return bool
     */
    public function isStopped(): bool
    {
        return !empty($this->data['validTo']);
    }
}

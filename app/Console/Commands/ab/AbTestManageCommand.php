<?php

namespace App\Console\Commands\ab;

use App\Services\ab\AbTestManagerService;

class AbTestManageCommand extends \Illuminate\Console\Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bc:ab:manage {abTestId} {commandName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start or stop AB tests';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Manage AB tests');
        $abTestId = $this->argument('abTestId');
        $command = $this->argument('commandName');

        $service = new AbTestManagerService($abTestId, $command);

        $errors = $service->validation();

        if (!empty($errors)) {
            foreach ($errors as $error) {
                $this->error($error);
            }
            exit;
        }

        $data = $service->getData();

        if ($command === AbTestManagerService::START) {
            if (!empty($data['validFrom'])) {
                $this->error('The AB test is running...');
                exit;
            } elseif (!empty($data['validTo'])) {
                $this->error('The AB test is ended, cannot restart it...');
                exit;
            }
            $service->setValidFrom();
        } elseif ($command === AbTestManagerService::STOP) {
            if (!empty($data['validTo'])) {
                $this->error('The AB test is ended, cannot stop again :)');
                exit;
            }
            $service->setValidTo();
        }
    }
}

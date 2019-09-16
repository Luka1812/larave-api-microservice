<?php

namespace App\Console\Commands\Test;

use Exception;
use Illuminate\Console\Command;
use Psr\Log\LoggerInterface;
use App\Services\OneView\TestWorkerService;

class TestWorkerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:worker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test worker which handles incoming messages.';

    /**
     * The log writer instance
     *
     * @var \Psr\Log\LoggerInterface
     */
    private $log;

    /**
     * The TestWorkerService instance
     *
     * @var \App\Services\OneView\TestWorkerService
     */
    private $testWorkerService;

    /**
     * Create a new console command instance.
     *
     * @param \Psr\Log\LoggerInterface $log
     * @param \App\Services\OneView\TestWorkerService $testWorkerService
     * @return void
     */
    public function __construct(LoggerInterface $log, TestWorkerService $testWorkerService)
    {
        parent::__construct();

        $this->log               = $log;
        $this->testWorkerService = $testWorkerService;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle() : void
    {
        $startMessage = 'The test:worker has started!';

        $this->info($startMessage);
        $this->log->info($startMessage);

        try {
            $this->testWorkerService->handle();
        } catch (Exception $exception) {
            // TODO: Log exception message.
        }

        $finishMessage = 'The test:worker has ended!';

        $this->info($finishMessage);
        $this->log->info($finishMessage);

        return;
    }
}

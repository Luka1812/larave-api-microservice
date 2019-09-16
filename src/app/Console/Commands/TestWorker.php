<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Psr\Log\LoggerInterface;

class TestWorker extends Command
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
     * Create a new console command instance.
     *
     * @param \Psr\Log\LoggerInterface $log
     * @return void
     */
    public function __construct(LoggerInterface $log)
    {
        parent::__construct();

        $this->log = $log;
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


        $finishMessage = 'The test:worker has ended!';
        $this->info($finishMessage);
        $this->log->info($finishMessage);

        return;
    }
}

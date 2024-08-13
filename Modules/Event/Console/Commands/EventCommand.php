<?php

namespace Modules\Event\Console\Commands;

use Illuminate\Console\Command;

class EventCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:EventCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Event Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return Command::SUCCESS;
    }
}

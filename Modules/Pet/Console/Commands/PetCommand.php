<?php

namespace Modules\Pet\Console\Commands;

use Illuminate\Console\Command;

class PetCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:PetCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pet Command description';

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

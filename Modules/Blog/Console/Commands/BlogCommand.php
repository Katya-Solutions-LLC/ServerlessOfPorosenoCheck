<?php

namespace Modules\Blog\Console\Commands;

use Illuminate\Console\Command;

class BlogCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:BlogCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Blog Command description';

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

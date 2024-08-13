<?php

namespace Modules\SetupWizard\Console\Commands;

use Illuminate\Console\Command;

class SetupWizardCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:SetupWizardCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'SetupWizard Command description';

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

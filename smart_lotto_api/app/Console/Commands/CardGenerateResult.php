<?php

namespace App\Console\Commands;

use App\Http\Controllers\CentralController;
use Illuminate\Console\Command;

class CardGenerateResult extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:cardResult';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $centralControllerObj = new CentralController();
        $centralControllerObj->createResultCard();
//        return Command::SUCCESS;
    }
}

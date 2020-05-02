<?php

namespace App\Console\Commands;

use App\Models\Item;
use Illuminate\Console\Command;

class CountUpElapsedTimeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'count-up-elapsed-time';

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
     * @return mixed
     */
    public function handle()
    {
        //
        $item = Item::find(1);

        if ($item === null) {
            return;
        }

        $item->elapsed_time++;
        $item->save();
    }
}

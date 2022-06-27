<?php

namespace App\Console\Commands;

use App\Models\Animal;
use Illuminate\Console\Command;

class AnimalsAge extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'animals:age';

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
        Animal::all()->each(function($item){
            $item->age();
        });
    }
}

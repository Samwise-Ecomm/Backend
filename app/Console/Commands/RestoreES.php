<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Invoice;
use App\Item;
use App\Offer;

class RestoreES extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'es:rebuild';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restores Elasticsearch';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Invoice::deleteIndex(); 
        // Invoice::createIndex();

        // Invoice::putMapping();
        // Item::putMapping();
        // Offer::putMapping();

        Invoice::addAllToIndex();
        Item::addAllToIndex();
        Offer::addAllToIndex();
    }
}

<?php

namespace App\Jobs;

use App\Batch\CategoryBatch;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CategoryInsertJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $batchSize;
    protected $totalRecords;

    public function __construct($batchSize, $totalRecords)
    {
        $this->batchSize = $batchSize;
        $this->totalRecords = $totalRecords;
    }

    public function handle()
    {
        $categoryBatch = new CategoryBatch($this->batchSize, $this->totalRecords);
        $categoryBatch->insertFakeCategories();
    }
}

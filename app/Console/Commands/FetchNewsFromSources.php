<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\News;
use App\Services\NewsSourceOne;
use App\Services\NewsSourceSecond;
use App\Services\NewsSourceThird;

class FetchNewsFromSources extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-news-from-sources';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch news and article from 3 different sources and update in database';

    /**
     * Execute the console command.
     */
    public function handle(NewsSourceOne $newsOne, NewsSourceSecond $newsSecond, NewsSourceThird $newsThird)
    {
        $combineNewsData = collect();

        $dataSourceOne = $newsOne->fetchData()->getResopnse();
        $dataSourceTwo = $newsSecond->fetchData()->getResopnse();
        $dataSourceThird = $newsThird->fetchData()->getResopnse();
        
        $combineNewsData = $combineNewsData->merge($dataSourceOne)->merge($dataSourceTwo)->merge($dataSourceThird);

        try {
           DB::beginTransaction();
        
            $chunks = $combineNewsData->chunk(1000);
            foreach ($chunks as $chunk) {
             News::insert($chunk->toArray());
            }
        
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
        }
    
        $this->info('Database updated successfully!');
    }
}

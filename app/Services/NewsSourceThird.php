<?php

namespace App\Services;

use App\Contracts\ApiServiceInterface;
use Illuminate\Support\Facades\Http;

class NewsSourceThird implements ApiServiceInterface
{
    protected $baseUrl = 'https://api.nytimes.com/svc/search/v2/articlesearch.json?q=election&api-key=lYbhxdsS3AfVEp8WGMYQRzl0jqYrWKU8';
    protected $response; 

    /**
     * Fetch data from the Third external API.
     *
     * This implementation of fetchData specifically handles the data retrieval
     * logic for the Third API. It processes and returns the data of this particular API.
     *
     * @return $this The instance of this class for method chaining.
     */
    public function fetchData()
    {
        $response = Http::get($this->baseUrl);
        $this->response = $response;
        return $this;
    }

    /**
     *
     * This method returns the processed response.  
     *
     * @return \Illuminate\Support\Collection A collection of formatted articles.
     */
    public function getResopnse()
    {
        
       $articleLists = collect();

       // Loop through each article in the response
       foreach ($this->response['response']['docs'] as $resp) {
        // Map the article data into a structured format
           $dataMap = [
               'title' => $resp['abstract'],
               'author' => $resp['byline']['person'][0]['firstname'] .' '. $resp['byline']['person'][0]['lastname'] ,
               'publishedAt' => date('Y-m-d H:i:s', strtotime($resp['pub_date'])),
               'url' => $resp['web_url'],
               'content' => $resp['snippet'],
               'description' => $resp['lead_paragraph'],
               'source' => $resp['source'],
               'category' => $resp['news_desk']
           ];

           // Add the formatted article to the collection
           $articleLists->push($dataMap);
       }
       return $articleLists;
    }

}
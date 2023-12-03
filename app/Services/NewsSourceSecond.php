<?php

namespace App\Services;

use App\Contracts\ApiServiceInterface;
use Illuminate\Support\Facades\Http;

class NewsSourceSecond implements ApiServiceInterface
{
    protected $baseUrl = 'https://content.guardianapis.com/search?page=2&q=debate&api-key=test';
    protected $response; 
    
    /**
     * Fetch data from the Second external API.
     *
     * This implementation of fetchData specifically handles the data retrieval
     * logic for the Second API. It processes and returns the data of this particular API.
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
       foreach ($this->response['response']['results'] as $resp) {
        // Map the article data into a structured format
           $dataMap = [
               'title' => $resp['webTitle'],
               'author' => isset($resp['author']) ? $resp['author'] : 'Guardians',
               'publishedAt' => date('Y-m-d H:i:s', strtotime($resp['webPublicationDate'])),
               'url' => $resp['webUrl'],
               'content' => isset($resp['content']) ? $resp['content'] : '',
               'description' => isset($resp['description']) ? $resp['description'] : '',
               'source' => isset($resp['source']) ? $resp['source']: '',
               'category' => $resp['pillarName']
           ];

           // Add the formatted article to the collection
           $articleLists->push($dataMap);
       }
       return $articleLists;
    }
}
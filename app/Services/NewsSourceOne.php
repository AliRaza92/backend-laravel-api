<?php

namespace App\Services;

use App\Contracts\ApiServiceInterface;
use Illuminate\Support\Facades\Http;

class NewsSourceOne implements ApiServiceInterface
{
    protected $baseUrl = 'https://newsapi.org/v2/everything?q=keyword&apiKey=6892f36ea4054af1ab6f6aed866a23f2';
    protected $response;

    /**
     * Fetch data from the first external API.
     *
     * This implementation of fetchData specifically handles the data retrieval
     * logic for the first API. It processes and returns the data of this particular API.
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
        foreach ($this->response['articles'] as $resp) {
            // Map the article data into a structured format
            $dataMap = [
                'title' => $resp['title'],
                'author' => $resp['author'],
                'publishedAt' => date('Y-m-d H:i:s', strtotime($resp['publishedAt'])),
                'url' => $resp['url'],
                'content' => $resp['content'],
                'description' => $resp['description'],
                'source' => $resp['source']['name'],
                'category' => 'News' // Static value indicating the category
            ];

            // Add the formatted article to the collection
            $articleLists->push($dataMap);
        }

    return $articleLists;
    }

}
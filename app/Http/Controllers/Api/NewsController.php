<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Http\Requests\NewsRequest;
use Illuminate\Http\Response;

class NewsController extends Controller
{
    public function fetchData(NewsRequest $request)
    {
        $query = News::query();

         // Apply category filter
        if ($name = $request->query('category')) {
            $query->where('category', 'like', "%{$request->category}%");
        }

        // Apply date filter
        if ($title = $request->query('date')) {
            $query->whereDate('publishedAt', 'like', "%{$request->date}%");
        }

        // Apply source filter
        if ($date = $request->query('source')) {
            $query->where('source', $request->source);
        }  
        
        // Apply author filter
        if ($date = $request->query('author')) {
            $query->where('author', 'like', "%{$request->author}%");
        }   

        $response = $query->get();
 
        return response()->json($response, Response::HTTP_OK);
    }
}

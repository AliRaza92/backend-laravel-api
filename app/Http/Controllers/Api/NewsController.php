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
        $query->when($request->query('category'), function ($q) use ($request) {
            return $q->where('category', 'like', "%{$request->query('category')}%");
        });


        // Apply date filter
        $query->when($request->query('date'), function ($q) use ($request) {
            return $q->whereDate('publishedAt', '>=', $request->query('date'));
        });

        // Apply source filter
        $query->when($request->query('source'), function ($q) use ($request) {
            return $q->where('source', $request->query('source'));
        });


        // Apply author filter
        $query->when($request->query('author'), function ($q) use ($request) {
            return $q->where('author', 'like', "%{$request->query('author')}%");
        });

        $response = $query->get();
 
        return response()->json($response, Response::HTTP_OK);
    }
}

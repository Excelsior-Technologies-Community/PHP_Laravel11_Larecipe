<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocAnalytics;
use App\Models\DocSearchHistory;

class DocsDashboardController extends Controller
{
    public function index()
    {
        $popularPages = DocAnalytics::orderBy('views', 'desc')->take(5)->get();
        $trendingSearches = DocSearchHistory::orderBy('count', 'desc')->take(5)->get();

        return view('docs.dashboard', compact('popularPages', 'trendingSearches'));
    }

    public function feedback(Request $request)
    {
        $analytics = DocAnalytics::firstOrCreate(
            ['page_path' => $request->page_path],
            ['views' => 0, 'likes' => 0, 'dislikes' => 0]
        );

        if ($request->type === 'like') {
            $analytics->increment('likes');
        } elseif ($request->type === 'dislike') {
            $analytics->increment('dislikes');
        }

        return response()->json(['success' => true]);
    }
}
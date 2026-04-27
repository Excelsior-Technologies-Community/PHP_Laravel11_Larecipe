<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocSearchHistory;

class DocsSearchController extends Controller
{
  public function store(Request $request)
{
    try {

        \Log::info($request->all());

        DocSearchHistory::create([
            'query' => $request->input('query'),
            'ip_address' => $request->ip()
        ]);

        return response()->json([
            'success' => true
        ]);

    } catch (\Exception $e) {

        \Log::error($e->getMessage());

        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
}
}
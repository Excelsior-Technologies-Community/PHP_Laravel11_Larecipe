<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\DocAnalytics;

class TrackDocsAnalytics
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($request->is('docs/*')) {

            $version = $request->segment(2);
            $page = $request->segment(3) ?? 'index';

            $record = DocAnalytics::where('version', $version)
                                  ->where('page', $page)
                                  ->first();

            if ($record) {
                $record->increment('views');
            } else {
                DocAnalytics::create([
                    'version' => $version,
                    'page' => $page,
                    'views' => 1
                ]);
            }
        }

        return $response;
    }
}
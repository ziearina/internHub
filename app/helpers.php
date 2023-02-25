<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\HtmlString;

if(!function_exists("generateUniqueToken")){

    function generateUniqueToken($size = 10,$table = null,$column = null)
    {
	    $token = Str::random($size);
	    if($table && \DB::table($table)->where($column,$token)->count()){
		     generateUniqueToken($size, $table, $column);
	    }
	    return $token;
    }
}

function vite_assets(): HtmlString
{
    $devServerIsRunning = false;
    
    if (app()->environment('local')) {
        try {
            Http::get("http://localhost:8000");
            $devServerIsRunning = true;
        } catch (Exception) {
        }
    }
    
    if ($devServerIsRunning) {
        return new HtmlString(<<<HTML
            <script type="module" src="http://localhost:8000/@vite/client"></script>
            <script type="module" src="http://localhost:8000/resources/js/app.js"></script>
        HTML);
    }
    
    $manifest = json_decode(file_get_contents(
        public_path('build/manifest.json')
    ), true);
    
    return new HtmlString(<<<HTML
        <script type="module" src="/build/{$manifest['resources/js/app.js']['file']}"></script>
        <link rel="stylesheet" href="/build/{$manifest['resources/js/app.js']['css'][0]}">
    HTML);
}
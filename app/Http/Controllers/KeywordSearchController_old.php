<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Http\Controllers\KeywordController;

class KeywordSearchController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    function getUrl(Request $request)
    {
        $search = $request->input('url');
        if(isset($search) && is_string($search)){
            if(substr($search, 0, 2) == 'r/' || substr($search, 0, 2) == 'R/' ){
                $search =  substr($search, 2);
            }
            $url = "https://www.reddit.com/r/".$search."/top.json?t=all";


        }

        return $url;

    }

    function getAndDecodeJson($url)
    {
        $string_reddit = file_get_contents ($url);

        $json = json_decode($string_reddit, $assoc = true);

        for ($i = 0; $i < 25 ; $i++) {
            $phrases[$i] =  $json["data"]["children"][$i]["data"]["title"];
        }

        return $phrases;


    }

    function getWordCounts($phrases) {
        $counts = array();
         foreach ($phrases as $phrase) {
             $words = explode(' ', $phrase);
             foreach ($words as $word) {
                $word = strtolower($word);
                $keyword = preg_replace("#[^a-zA-Z\-]#", "", $word);
                if (isset($counts[$keyword])){
                    $counts[$keyword] += 1;
                  } else {
                    $counts[$keyword] = 0;
                  }
             }
         }
         return $counts;
     }

     function twoOrMore($var){

        return($var > 1);
     }

     function keywordSearch(Request $request){

        $search = $request->input('url');
        if(isset($search) && is_string($search)){
            if(substr($search, 0, 2) == 'r/' || substr($search, 0, 2) == 'R/' ){
                $search =  substr($search, 2);
            }
            $url = "https://www.reddit.com/r/".$search."/top.json?t=all";
        }

        $phrases = KeywordSearchController::getAndDecodeJson($url);
        $counts = KeywordSearchController::get_word_counts($phrases);
        arsort($counts);
        $counts = array_filter($counts, array($this,"twoOrMore"));
        return $counts;
     }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


class KeywordSearcherController extends JsonController
{
    public $url;
    public $json;
    public $titles;
    public $words;
    public $keywords;
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
    function getTitles($json)
    {
        /*for ($i = 0; $i < 25 ; $i++) {
            $titles[$i] =  $json["data"]["children"][$i]["data"]["title"];
        }*/
        foreach ($json["data"]["children"] as $key => $value){
            $titles[$key] =  $json["data"]["children"][$key]["data"]["title"];
        }

        return $titles;
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
        $counts = KeywordSearchController::getWordCounts($phrases);
        arsort($counts);
        $counts = array_filter($counts, array($this,"twoOrMore"));
        return $counts;
     }

     function keywordSearcher(Request $request){

        $search = New KeywordSearcherController();

        $search->url->getUrl($request);
        $search->json->getAndDecodeJson($search->url);
        $search->titles->getTitles($search->json);
        $search->words->getWordsArray($search->titles);
        $search->words->cleanWordsArray($search->words);

     }
}

<?php
/* JsonController, getUrl and GetandDecode

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

    return $json;


}
*/
//Example for tinker





namespace App\Http\Controllers;
use App\Http\Controllers\JsonController;

class tinkerController extends JsonController
{
    public $url;
    public $json;
    public $titles;
    public $words;
    public $keywords;

    function getTitles($json)
    {
        foreach ($json["data"]["children"] as $key){
            //$titles[$key] =  $json["data"]["children"][$key]["data"]["title"];
            dd($key);
        }

       // return $titles;
    }

    function getWordsArray($titles)
    {
        $words = array();
        for ($i = 0; $i < 25 ; $i++) {
            $words[$i] = explode(' ', $titles[$i]);

        }
        return $words;
    }

    function cleanAndCountWords($words)
    {
        $counts = array();
        foreach ($words as $word) {
            $word = strtolower($word);
            $keyword = preg_replace("#[^a-zA-Z\-]#", "", $word);
            if (isset($counts[$keyword])){
                $counts[$keyword] += 1;
            } else {
                $counts[$keyword] = 0;
            }
        }
        return $counts;
    }
}

    $string_reddit = file_get_contents ("https://www.reddit.com/subreddits/search.json?q=laravel");
    $json = json_decode($string_reddit, $assoc = true);
    $search = New tinkerController();

    $search->json = $json;
    $search->titles = $search->getTitles($search->json);
    $search->words = $search->getWordsArray($search->titles);
    $search->words = $search->cleanAndCountWords($search->words);

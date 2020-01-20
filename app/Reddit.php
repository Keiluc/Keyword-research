<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reddit /*extends Model*/
{

    public $url;
    public $json;
    public $titles;
    public $words;
    public $keywords;


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

    function getJsonArray($url)
    {
        $string_reddit = file_get_contents ($url);

        $json = json_decode($string_reddit, $assoc = true);

        return $json;


    }

    function getTitles($json)
    {
        foreach ($json["data"]["children"] as $key => $value){
            $titles[$key] =  $value["data"]["title"];
        }

        return $titles;
    }

    function getAndCheckWords($titles){
        $words_count = [];
        $i = 0;
        foreach($titles as $title){
            $words = explode(' ', $title);
            $words_count[$i] = $this->WordsCounter($words);
            $i++;

        }
        return $words_count;
    }

    function WordsCounter ($words)
    {

        foreach($words as $word)
        {
            $word = strtolower($word);
            $keyword = preg_replace("#[^a-zA-Z\-]#", "", $word);

            if (isset($words_count[$keyword])){
                $words_count[$keyword] += 1;
            } else {
                $words_count[$keyword] = 0;
            }

        }

        return $words_count;
    }

    function cleanArrayWords($words)
    {
        arsort($words);
        $words = array_filter($words, array($words,"twoOrMore"));
        return $words;
    }

    function twoOrMore($var){

        return($var > 1);
     }
}
$string_reddit = file_get_contents ("https://www.reddit.com/subreddits/search.json?q=marketing");

$lala = new reddite();
$lala->json = json_decode($string_reddit, $assoc = true);
$lala->titles = $lala->getTitles($lala->json);
$lala->words = $lala->getAndCheckWords($lala->titles);


arsort($counts);
        $counts = array_filter($counts, array($this,"twoOrMore"));
        return $counts;

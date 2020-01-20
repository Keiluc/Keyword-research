<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public $url;
    public $json;
    public $posts = array();
    public $titles = array();
    public $text_titles;
    public $words = array();
    public $words_count;


    function keywordReserch(Request $request)
    {
        $this->getUrl($request);
        $this->getJsonArray($this->url);
        $this->getPosts($this->json);
        $this->getTitles($this->posts);
        $this->getAllTitles($this->titles);
        $this->getAndCheckWords($this->text_titles);
        $this->wordsCounter($this->words);
        $this->show($this->words_count);

    }

    function getUrl($request)
    {
        $search = $request->input('url');
        $search = $this->validateRequest($search);
        $this->url = "https://www.reddit.com/r/".$search."/top.json?t=all";
    }

    function validateRequest ($search)
    {
        if(isset($search) && is_string($search)){
            if(substr($search, 0, 2) == 'r/' || substr($search, 0, 2) == 'R/' ){
                $search =  substr($search, 2);
            }
        }
        return $search;
    }

    function getJsonArray($url)
    {
        $string_reddit = file_get_contents($url);
        $this->json = json_decode($string_reddit, $assoc = true);
    }

    function getPosts($json)
    {
        foreach ($json["data"]["children"] as $key => $value)
        {
            $this->posts[$key] = $value["data"];
        }

    }

    function getTitles($posts)
    {
        $i = 0;
        foreach($posts as $post)
        {
            $this->titles[$i] = $post['title'];
            $i++;
        }
    }

    function getAllTitles($titles)
    {
        foreach($titles as $title)
        {
            $this->text_titles .= $title;
        }
    }

    function getAndCheckWords($text_titles)
    {

        $this->words = explode(' ', $text_titles);
        //$this->words[$i] = $this->WordsCounter($words);
        $this->words_count = $this->wordsCounter($this->words);
    }

    function wordsCounter($words)
    {

        foreach($words as $word)
        {
            $word = strtolower($word);
            $keyword = preg_replace("#[^a-zA-Z\-]#", "", $word);

            if (isset($words_count[$keyword]) && ($keyword !== "" )){
                $words_count[$keyword] += 1;
            } else {
                $words_count[$keyword] = 0;
            }

        }

        $words = $this->cleanArrayWords($words_count);
    }

    function cleanArrayWords($words)
    {
        arsort($words);
        foreach($words as $word => $value)
        {
            if ($value <= 1 || $word = "")
            {
                unset($words[$word]);
            }
        }
        $this->words_count = $words;
    }

    function show($words_count)
    {
        return view('home', ['keywords' => $this->words_count]);
    }

}

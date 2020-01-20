<?php
$string_reddit = file_get_contents ("https://www.reddit.com/r/DigitalMarketing/top.json?t=all");
$json = json_decode($string_reddit, $assoc = true);
//$json["data"]["children"][0]["data"]["title"];

for ($i = 0; $i < 25 ; $i++) {
    $phrases[$i] =  $json["data"]["children"][$i]["data"]["title"];
}
//$phrases = all titles


function getAndDecodeJson($url)
    {
        $string_reddit = file_get_contents ($url);

        $json = json_decode($string_reddit, $assoc = true);

        for ($i = 0; $i < 25 ; $i++) {
            $phrases[$i] =  $json["data"]["children"][$i]["data"]["title"];
        }

        return $phrases;


    }

function get_word_counts($phrases) {
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

 function two_or_more($var){

    return($var > 1);
 }


        $counts = get_word_counts($phrases);
        arsort($counts);
        $counts = array_filter($counts, "two_or_more");
        print_r($counts);






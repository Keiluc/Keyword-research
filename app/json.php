<?php

//Obtener archivo json (array)

$string_reddit = file_get_contents ("https://www.reddit.com/subreddits/search.json?q=laravel");
$json = json_decode($string_reddit, $assoc = true);
//$json["data"]["children"][0]["data"]["title"];

for ($i = 0; $i < 25 ; $i++) {
    $phrases[$i] =  $json["data"]["children"][$i]["data"]["title"];
}

//$titles = array con todos los titulos
//str_word_count — Devuelve información sobre las palabras utilizadas en un string


for ( $i = 0; $i<25; $i++){
    $words[$i] = explode(" ", $phrases[$i] );
}
//$words Array con todas las palabras con los titulos como indice numerico
//////////////////////

function get_word_counts($phrases) {
    $counts = array();
     foreach ($phrases as $phrase) {
         $words = explode(' ', $phrase);
         foreach ($words as $word) {
           $word = preg_replace("#[^a-zA-Z\-]#", "", $word);
             $counts[$word] += 1;
         }
     }
     return $counts;
 }

 $phrases = file_get_contents ("https://www.reddit.com/r/DigitalMarketing/top.json?t=all");

 $counts = get_word_counts($phrases);
 arsort($counts);
 print_r($counts);








/*for ( $i = 0; $i<25; $i++){
    for ( $e = 0; $e<25; $e++){

        $pattern = $words [$i][$e];

        $words_string = implode(" ", $words);
        preg_march_all($pattern, $words_string, $matches);

    }
}
















//mostrar en forma de tabla, Ranking Word (Matches) y frequency
$frecuency = array_count_values($matches[0]);
arsort($frecuency);

echo "Rank\tWord\tFrequency\n====\t====\t=========\n";
$i = 1;
foreach ($frecuency as $matches => $count) {
    echo $i . "\t" . $match . "\t" . $count . "\n";
    if ($i >= 10) {
        break;
    }
    $i++;
}

/*
HP Preg_split
Veamos ahora otro ejemplo que usa la función preg_split.

Tomaremos una frase de cadena y la explotaremos en una matriz; El patrón que debe coincidir es un espacio único.

La cadena de texto que se utilizará en este ejemplo es "Me encantan las expresiones regulares".

El siguiente código ilustra la implementación del ejemplo anterior.

<? php

$ my_text = "Me encantan las expresiones regulares";

$ my_array = preg_split ("/ /", $ mi_texto);

print_r ($ my_array);

?>
*/

function countWords($text){//desde el texto
  $text = strip_tags($text);//borrarlas etiquetasHTML
  $text = strtolower($text);//todoaminúsculas
  $text = str_replace (array('\\r\\n', '\\n', '+'), ',', $text);//sustituir alos posibles saltos de linea
  $text = str_replace (array('–','(',')',':','.','?','!','_','*','-'), '', $text);//reemplazar el carácterno es válido
  $text = str_replace (array(' ','.'), ',', $text);//sustituir por comas

  $wordCounter=array();//array paramantenerla palabra->númeroderepeticiones

  $arrText=explode(",",$text);//Crear un array con las palabras

  unset($text);

foreach ($arrText as $value)  {
    $value=trim($value);//quitar espacios
    if ( strlen($value)>0 ) {//mayor que 0


        if (array_key_exists($value,$wordCounter)){//si la clave existe
        else $wordCounter[$value]=1;//creando clave
        }
    }

    unset($arrText);

    uasort($wordCounter,"cmp");//short from bigger to smaller

    $keywords="";

    foreach($wordCounter as $key=>$value){
        $keywords.="".$key." => ".$value."";
    }
    $keywords.="";
    unset($wordCounter);
    return $keywords;
}
function cmp($a, $b) {//Ordenar los numeros descendientemente
    if ($a == $b) return 0;
    return ($a < $b) ? 1 : -1;
}
-----


Código:

function tag_key($texto){
$content = str_replace(array("
","\r\n","\n","\n\n",",",".",',', ')',  '(', '.', "'", '"','<', '>', ';', '!', '?', '/', '-','_', '[',  ']', ':', '+', '=', '#','$', '"', '©', '>', '<',chr(10), chr(13),  chr(9)),"",$texto);
$ketxt = preg_replace('/ {2,}/si', " ", $content);
$t = explode(" ", $ketxt);
$total = count($t);
$tg = "";
$i = 0;
foreach($t as $v){ $i++;
$coma = ($i < $total-1) ? ", " : " ";
$tg .= (strlen($v) >= 5 && strlen($v) <= 8) ? ($v.$coma) : "";
}
$tag = strtolower($tg);
return ($tag);
}

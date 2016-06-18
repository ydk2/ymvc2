<?php

function value_in($element_name, $xml, $content_only = false) {
    if ($xml == false) {
        return false;
    }
    $found = preg_match('#<'.$element_name.'(?:\s+[^>]+)?>(.*?)'.
            '</'.$element_name.'>#s', $xml, $matches);
    if ($found != false) {
        if ($content_only) {
            return $matches[1];  //ignore the enclosing tags
        } else {
            return $matches[0];  //return the full pattern match
        }
    }
    // No match found: return false.
    return false;
}

$html = file_get_contents("data.xml");
$p = xml_parser_create();
xml_parser_set_option($p, XML_OPTION_CASE_FOLDING, 0);
xml_parser_set_option($p, XML_OPTION_SKIP_WHITE, 1);
xml_parse_into_struct($p, $html, $vals, $index);
xml_parser_free($p);
//echo "Index array\n";
$j = 0;
foreach($vals as $k => $v){
    if($v['type'] == "open"){
        if($v['level'] > 1){
        echo ",";
        }
        echo "{\"".$v['tag']."\":";
        if(isset($v['attributes'])){
        $i = 0;
        echo "[";
        foreach ($v['attributes'] as $a => $b){
        echo "\"$a\":\"$b\"";
        $i++;
        if(count($v['attributes']) != $i){
        echo ",";    
        }
        }
        echo "]";
        }
    }
    if($v['type'] == "cdata"){
        echo "".":";
    }
    if($v['type'] == "close"){
        echo ""."}";
    }
    if($v['type'] == "complete"){
        if($v['level'] > 1){
        echo ",";
        }
        
        echo "{ \"".$v['tag']."\":\"".$v['value']."\"";
        
        if(isset($v['attributes'])){
        $i = 0;
        echo "[";
        foreach ($v['attributes'] as $a => $b){
        echo "\"$a\":\"$b\"";
        $i++;
        if(count($v['attributes']) != $i){
        echo ",";    
        }
        }
        echo "]";
        }
        
        echo "}";
    }

}

//print_r($index);
echo "\nVals array\n";
print_r($vals);
//preg_match_all('/<t>(.*?)<\/t>/s', $html, $matches);

//HTML array in $matches[1]
//print_r($matches[1]);

//$title = value_in('t', $html);
//print_r($title);
?>
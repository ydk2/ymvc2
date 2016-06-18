<?php
/**
 * 
 */
class theme {
    
static function search_tag($tag, array_xml $object,$array = null){
$output = array();
foreach ($object->paths($array) as $key => $value) {
    $find = explode('/', $value);
    if(in_array($tag, $find) && !in_array("@attributes", $find)){
        $output[] = $value;
    }
}
return $output; 
}
static function load_module_insert_before($name,$content,array_xml $object,$role = 'id'){
$i = 0;
$object_path = $object->_get_path_by_attr($role, $name,$object->array,FALSE);
//$attr = $object->_get($object_path."/@attributes");
$f = $object->get($object_path."");
$object->_unshift($content,$f);
$object->set($object_path."", $f);
//$object->_set($object_path."/@attributes", $attr);
}
static function load_module_insert($name,$content,array_xml $object,$i = 0,$true=FALSE,$role = 'id'){
$object_path = $object->_get_path_by_attr($role, $name,$object->array,$true);
$object->insert($object_path."",$content,$i);
}
static function load_module_put($name,$content,array_xml $object,$i = 0,$true=FALSE,$role = 'id'){
$object_path = $object->_get_path_by_attr($role, $name,$object->array,$true);
$f = $object->get($object_path."");
$f = $object->_put($content,$i,$f);
$object->set($object_path."", $f);
}
static function load_module_append($name,$content,array_xml $object,$true=FALSE,$role = 'id'){
$object_path = $object->_get_path_by_attr($role, $name,$object->array,$true);
$f = $object->get($object_path."");
$object->_push($content,$f);
$object->set($object_path."", $f);
}
static function load_module_set($name,$content,array_xml $object,$i='/0',$true=FALSE,$role = 'id'){
$object_path = $object->_get_path_by_attr($role, $name,$object->array,$true);
$object->set($object_path."$i", $content);
}
static function load_module_unset($name,array_xml $object,$i='/0',$true=FALSE,$role = 'id'){
$object_path = $object->_get_path_by_attr($role, $name,$object->array,$true);
$object->del($object_path."$i");
//echo "$object_path";
}
static function load_module_cp($name,$new,array_xml $object,$add=null,$true=FALSE,$role = 'id'){
$path = $object->_get_path_by_attr($role, $name,$object->array,$true);
$path2 = $object->_get_path_by_attr($role, $new,$object->array,$true);
$object->cp($path, $path2, $add);
//echo "$object_path";
}
static function load_module_move($name,$new,array_xml $object,$true=FALSE,$role = 'id'){

$path = $object->_get_path_by_attr($role, $name,$object->array,$true);
$path2 = $object->_get_path_by_attr($role, $new ,$object->array,$true);
$object->move($path, $path2);
//echo "$object_path";
}
static function load_module_ren($name,$new,array_xml $object,$true=FALSE,$role = 'id'){
$path = $object->_get_path_by_attr($role, $name,$object->array,$true);
//$path2 = $object->_get_path_by_attr($role, $new,$object->array,$true);
$object->ren($path, $new);
//echo "$object_path";
}
static function from_xml($xml,array_xml $object){
$xml = new XML2Array($xml);
$object_array = $xml->out;
$xml->close();
return $object->get('theme',$object_array);
}
 
static public function load_module_menu($list,$lang,$add=NULL){
$i = 0;
$menu = array();
foreach ($list as $key => $value) {
    $link = trim($add.",".$value['get'],",");
    $menu['ul'][$i]['li']['a']=array($value['name']);
    $menu['ul'][$i]['li']['a']['@attributes']['href']="?lang=$lang&site=$link"; //$link;
    if(isset($value['sub'])){
    if (is_array($value['sub'])) {
        $a['a']=array($value['name']);
        $a['a']['@attributes']['href']="?lang=$lang&site=$link";
       $menu['ul'][$i]['li']=array($a,self::load_module_menu($value['sub'],$lang,$link));
    } 
    }
    $i++;
}
return $menu;
}
static public function load_module_menu_lang($lists){
$i = 0;
$lang = array();
$menu_object = new array_xml($lists);
foreach ($lists as $key => $value) {
    $ldate = $menu_object->get("$key/date"); 
    $lname = $menu_object->get("$key/name");
    $lget = $menu_object->get("$key/get");  
    $lang[0]['ul'][$i]['li']['a']['@attributes']['href']="?lang=$lget"; //$link;
    $lang[0]['ul'][$i]['li']['a'][0]=$lname;    
    $lang[1][] = $lget;
    $i++;  
}  
$menu_object->close();
return $lang;
} // load_module_menu_lang

static public function get_content($what, $where){
$_obj = new array_xml($where);
$article_path = $_obj->search_key($what);
$tmp[0] = explode($what, $article_path[0]);
$tmp[0] = $tmp[0][0].$what;
$article = $_obj->get($tmp[0]);
$_obj->close();  
return $article;  
}
} // end theme
?>
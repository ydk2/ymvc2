<?php
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['inicjuj']))
{
session_regenerate_id();
$_SESSION['inicjuj'] = true;
$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
}
if($_SESSION['ip'] != $_SERVER['REMOTE_ADDR'])
{
session_destroy();
echo "<div>Zweryfikuj dane! <a href=\"http://".dirname($_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'])."/login.php\"><button>Weryfikuj</button></a></div>";
exit();  
?>

<?php    
}
if(!isset($_SESSION['uzytkownik']))
{
// Sesja się zaczyna, wiec inicjujemy użytkownika anonimowego
$_SESSION['uzytkownik'] = 0;
}
if($_SESSION['uzytkownik'] > 0)
{
?>
<!DOCTYPE html >
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>write</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta content="text/html; charset=UTF-8" http-equiv="content-type"/>
<!-- TinyMCE -->
<script type="text/javascript" src="http://<?=dirname($_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'])?>/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
<!-- /TinyMCE -->

</head>
<body role="application">
<?php
$host = $_SERVER['HTTP_HOST'];
$script = $_SERVER['SCRIPT_NAME'];
$full = "http://".$host.$script.$_SERVER['PATH_INFO'];
$infop = (isset($_SERVER['PATH_INFO']))? substr($_SERVER['PATH_INFO'], 1):'';
require_once 'ui.php';
require_once 'ini.php'; 

//znajdz("./default.theme");

function znajdz($themefile="./default.theme",$inifile="./default.ini"){
     try{
    
    $host = $_SERVER['HTTP_HOST'];
    $script = $_SERVER['SCRIPT_NAME'];
    $full = "http://".$host.$script.$_SERVER['PATH_INFO'];
    $x = parse_ini_file($inifile,TRUE);
        $c = new ui\FormUI;
        $c->form($full,1,3,'style=border:1px solid black;');
        $a='';
        $file = file_get_contents($themefile); 
        $file = str_replace("}","}".PHP_EOL,$file);
        preg_match_all('({\$.*})',$file,$match);
        if ($_POST){
            $b = new ini($inifile);
        }
        
                ////////////////////////////////////////////
        $z['none']='none';
        foreach($x as $k1=>$v1){
        //echo "$k<br>";
        if (!isset($x[$k1])) {
        $k1++;   
        } else {   
        $z[strval($k1)]=$x[$k1]['url'];
        }
        }
       $select = (isset($_GET['edit']))?$_GET['edit']:strval(intval($k1+1) );
        $z[strval(intval($k1+1))]= 'add new ';//count($z) ;//'add';
        $c->input('submit', NULL,'zapisz',NULL,'style=border:1px solid black;');
        $c->input('option', 'uri', $z ,$select,'style=border:1px solid black;');
        $c->tekst('<b> Add new or replace or </b>');
        $c->input('checkbox', 'del',NULL,NULL,'style=border:1px solid black;');
        $c->tekst('<b>Delete</b>');
        $c->input('checkbox', 'ins',NULL,NULL,'style=border:1px solid black;');
        $c->tekst('<b>insert or move </b>');
        array_pop($z); 
        $c->input('option', 'move', $z ,'none','style=border:1px solid black;'); 
        $c->tekst('<b> here</b><br>');      
        foreach ($match as $key => $value) {
           
            foreach ($value as $k => $v) {
            $g = substr($v,7,-3);
            switch ($g) {
                case 'menu':
                    break;
                case 'dirhost':
                    break;
                case 'url':
                    $c->input_valid('text', $g ,(isset($_GET['edit'])&&$_GET['edit']!='')?htmlspecialchars(@$x[$_GET['edit']][$g], ENT_QUOTES):NULL,'good','bad','style=border:1px solid black;');
                    $c->tekst('<b>'.$g.'</b>');
                    
                    $c->input('checkbox', 'ren',NULL,NULL,'style=border:1px solid black;');
                    $c->tekst('<b> Rename </b><br />');
                    if ($_POST){
                    (@$_POST[$g]!='')?$b->set(@$_POST['url'],$g,@$_POST[$g]):'';
                    }
                    break;
                case 'content':
                    $c->tekst('<b> '.$g.' </b>');
                    $c->tekst("<a href=\"javascript:;\" onmousedown=\"tinyMCE.get('$g').show();\">Show</a>");
                    $c->tekst("<a href=\"javascript:;\" onmousedown=\"tinyMCE.get('$g').hide();\">Hide</a><br />");
                    $c->input('textarea', $g,(isset($_GET['edit'])&&$_GET['edit']!='')?base64_decode(@$x[$_GET['edit']][$g]):NULL,NULL,'style=width:290px;height:150px;border:1px solid black;');
                    $c->tekst('<br>');
                    
                    if ($_POST){
                    (@$_POST[$g]!='')?$b->set(@$_POST['url'],$g,base64_encode(@$_POST[$g])):'';
                    }
                    break;
                case 'header':
                    $c->tekst('<b> '.$g.' </b>');
                    $c->tekst("<a href=\"javascript:;\" onmousedown=\"tinyMCE.get('$g').show();\">Show</a>");
                    $c->tekst("<a href=\"javascript:;\" onmousedown=\"tinyMCE.get('$g').hide();\">Hide</a><br />");
                    $c->input('textarea', $g,(isset($_GET['edit'])&&$_GET['edit']!='')?base64_decode(@$x[$_GET['edit']][$g]):NULL,NULL,'style=width:290px;height:150px;border:1px solid black;');
                    $c->tekst('<br>');
                    
                    if ($_POST){
                    (@$_POST[$g]!='')?$b->set(@$_POST['url'],$g,base64_encode(@$_POST[$g])):'';
                    }
                    break;
                    case 'footer':
                    $c->tekst('<b> '.$g.' </b>');
                    $c->tekst("<a href=\"javascript:;\" onmousedown=\"tinyMCE.get('$g').show();\">Show</a>");
                    $c->tekst("<a href=\"javascript:;\" onmousedown=\"tinyMCE.get('$g').hide();\">Hide</a><br />");
                    $c->input('textarea', $g,(isset($_GET['edit'])&&$_GET['edit']!='')?base64_decode(@$x[$_GET['edit']][$g]):NULL,NULL,'style=width:290px;height:150px;border:1px solid black;');
                    $c->tekst('<br>');
                    
                    if ($_POST){
                    (@$_POST[$g]!='')?$b->set(@$_POST['url'],$g,base64_encode(@$_POST[$g])):'';
                    }
                    break;
                default:
                    $c->input_valid('text', $g ,(isset($_GET['edit'])&&$_GET['edit']!='')?htmlspecialchars(@$x[$_GET['edit']][$g], ENT_QUOTES):NULL,'good','bad','style=border:1px solid black;');
                    $c->tekst('<b>'.$g.'</b><br>');
                    
	
                    if ($_POST){
                    (@$_POST[$g]!='')?$b->set(@$_POST['url'],$g,@$_POST[$g]):'';
                    }
                    break;
            }            
            }
                
        }

        $c->captha('captha', 'kod');
        
        $c->form();
        /////////////////////////////////////////////////////////
         if ($_POST){
               if (@$_POST['uri']!='' AND @$_POST['uri']!='none'){
               		if(isset($_POST['del']) && @$_POST['uri']!='0' && array_key_exists(@$_POST['uri'],$x) ){
               			$b->del($_POST['uri']);
               			//$c->tekst("<h2>Usunięto</h2><br />");
               			echo "<b>Usunięto</b><p><a href=\"http://$host$script/write/\">Wróć<a></p>";
               		} elseif(isset($_POST['ins']) && @$_POST['ins']!='' && array_key_exists(@$_POST['uri'],$x) ){
                        $b->put($_POST['uri'],$_POST['url'],1);
                        //$c->tekst("<h2>Usunięto</h2><br />");
                        echo "<b>Dodano</b><p><a href=\"http://$host$script/write/\">Wróć<a></p>";
                        echo "<p><a href=\"http://$host$script/{$_POST['url']}/\">Zobacz<a></p>";
                    } elseif(isset($_POST['move']) && @$_POST['move']!='none' && array_key_exists(@$_POST['uri'],$x) ){
                        $b->move($_POST['move'],$_POST['uri']);
                        //$c->tekst("<h2>Usunięto</h2><br />");
                        echo "<b>Przeniesiono</b><p><a href=\"http://$host$script/write/\">Wróć<a></p>";
                        echo "<p><a href=\"http://$host$script/{$_POST['uri']}/\">Zobacz<a></p>";
                    } elseif(isset($_POST['ren']) && @$_POST['uri']!=$_POST['url'] && array_key_exists(@$_POST['uri'],$x) ){
                        $b->ren($_POST['uri'],$_POST['url']);
                        $b->set($_POST['url'],'uri',$_POST['url']);
                        $b->set($_POST['url'],'url',$_POST['url']);
                        //$c->tekst("<h2>Usunięto</h2><br />");
                        echo "<b>Zmieniono nazwę</b><p><a href=\"http://$host$script/write/\">Wróć<a></p>";
                        echo "<p><a href=\"http://$host$script/{$_POST['url']}/\">Zobacz<a></p>";
                    } else {
               		$b->set(@$_POST['url'],'uri',@$_POST['url']);
               		echo "<b>Wysłano!!!</b><p><a href=\"http://$host$script/write\">Wróć<a></p>";
               		echo "<p><a href=\"http://$host$script/{$_POST['uri']}/\">Zobacz<a></p>";
				    foreach ($_POST as $key => $value) {
				        
        				echo "<p>$key: ".str_replace(PHP_EOL, "<br />",$value)."</p>";
    				}
               		}
                    
               		$b->write();
               		
               	} else {
               		//$c->tekst("<h2>Pusty tytuł strony</h2><br />");
               		echo "<b>Pusty tytuł strony</b><p><a href=\"http://$host$script/write\">Wróć<a></p>";
               	}
            } else {
            	echo "<b>Zmień lub dodaj stronę</b>";
        		$c->pokaz();
            }
        } catch (Exception $exception) {
        echo 'Problem: '.$exception->getMessage().'<br/>';
        }
      } 
///////////////////////////////////////////////////
echo "<p><a href=\"http://$host$script\">$host<a> | <a href=\"http://$host$script/write\">Write<a> | <a href=\"".dirname("http://$host$script")."/login.php\">konto<a></p>";
///////////////////////////////////////////////////
$c='./default.ini';
$d = parse_ini_file("./logindata.ini.php",TRUE);
$theme= $d['usersdata']['theme'];//"./default.theme";
$a = (@$_SERVER['PATH_INFO'])? $_SERVER['PATH_INFO']:'/';
$g = explode('/',$a);
reset($g);
$e = (isset($g[key($g)+2]))?"./{$g[key($g)+2]}.ini":$c;
echo $e;
$a = (@$_SERVER['PATH_INFO'])? end($g):'';
	
	znajdz("./default.theme",$e);

echo "<hr /><pre>";
//print_r(parse_ini_file($inifile,TRUE));
echo "</pre><hr />";
?>
<script type="text/javascript">
if (document.location.protocol == 'file:') {
	alert("The examples might not work properly on the local file system due to security settings in your browser. Please use a real webserver.");
}
</script>
</body>
</html>
<?php
}
else
{
	header('location:http://'.dirname($_SERVER[HTTP_HOST].$_SERVER[SCRIPT_NAME]).'/login.php');
	//require("./login.php");
	?>
<!DOCTYPE HTML>
<html>
<head>
<meta content="text/html; charset=UTF-8" http-equiv="content-type"/>
	<link href="<?=dirname(TEN);?>/style/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php 
	echo "<div style=\"width:100%; height:100%;background-color:gray;padding:20px;\"><div style=\"background-color:white;border: 1px black solid;padding:5px;width:200px;height:100px;margin-left:auto; margin-right:auto;text-align:center;\"><p><a href=\"http://".dirname($_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'])."/login.php\"><button> Zaloguj się! </button></a></p><p><a href=\"http://".dirname($_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'])."\"><button> Powrót </button></a></p></div>";
?>
</body></html>
<?php	
}
?>
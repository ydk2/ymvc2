<?php
        $host = $_SERVER['HTTP_HOST'];
        $script = $_SERVER['SCRIPT_NAME'];
        $full = "http://".$host.$script;
        $dirhost = "http://".dirname($host.$script);
?>
<div id="gal">
<script type="text/javascript">
    var GB_ROOT_DIR = "<?=$dirhost;?>/greybox/";
</script>
<script type="text/javascript" src="<?=$dirhost;?>/greybox/AJS.js"></script>
<script type="text/javascript" src="<?=$dirhost;?>/greybox/AJS_fx.js"></script>
<script type="text/javascript" src="<?=$dirhost;?>/greybox/gb_scripts.js"></script>
<link href="<?=$dirhost;?>/greybox/gb_styles.css" rel="stylesheet" type="text/css" />
<link href="<?=$dirhost;?>/gal_style.css" type="text/css" rel="stylesheet"/>
<?php
function imgType($name)
{
	$path_part = pathinfo($name);
	$roz = $path_part['extension'];
	switch ($roz) {
		case 'jpg' || 'jpeg' || 'jpe':
			return "IMAGETYPE_JPEG";
			break;
		case 'gif':
			return "IMAGETYPE_GIF";
			break;
		case 'png':
			return "IMAGETYPE_PNG";
			break;
		
	}
}
 
function resizeImage($source, $save_image,$max_x, $max_y,$jpeg_quality = 90)
{
   /*
	* source - obrazek jpeg
	* max_x - maksymalna szerokosc pomniejszonego obrazka
	* max_y - maksymalna dlugosc pomniejszonego obrazka
	* save_image - nazwa pliku do ktorego zostanie zapisany nowy obrazek
	* jpeg_quality - jakosc powstalego obrazu jpeg - jezeli bedzie inny to argument jest nie wazny (domyslnie 90)
	*/
 
	if (imgType($source) == "IMAGETYPE_JPEG"){
		$img_src = imagecreatefromjpeg($source);
	} 
 
	$image_x = imagesx($img_src);
	$image_y = imagesy($img_src);
	$new_x = $max_x;
	$new_y = $max_y;
 
	$new_img = imagecreatetruecolor($new_x, $new_y);
	imagecopyresampled($new_img, $img_src, 0, 0, 0, 0, $new_x, $new_y, $image_x, $image_y);
 
	if(imgType($save_image) == "IMAGETYPE_JPEG") {
		imagejpeg($new_img, $save_image, $jpeg_quality);
		imagedestroy($new_img);
		clearstatcache();
	}
}
?>
<?php
function usun($mini){
	
	if ($handle = opendir($mini)) {
    while (false !== ($file = readdir($handle))) { 
	$extm=pathinfo($file);
	$extd = $extm['extension'];
//	$eext ='/[jpeg\JPEG\jpg\JPG]$/';
//	$fext = preg_match($eext,$extd);
	$extg = $extd === 'jpg' || $extd === 'JPG' || $extd === 'jpeg' || $extd === 'JPEG' || $extd === 'jpe' || $extd === 'JPE' ;
        if (!is_dir($file) && $extg) { 
            
			if(!file_exists(dirname($mini).'/obrazki/'.$file)) {
				//chmod('./mini/'.$file, 0755);
				 unlink($mini.DIRECTORY_SEPARATOR.$file);
			}
        } 
    }
    closedir($handle); 
    clearstatcache();
}
}

?><br>
<?php
function mini($tdir='.')
{
        $host = $_SERVER['HTTP_HOST'];
        $script = $_SERVER['SCRIPT_NAME'];
        $full = "http://".$host.$script;
        $dirhost = "http://".dirname($host.$script);
	$dirs = scandir($tdir);
if(isset($_SESSION['uzytkownik']) && $_SESSION['uzytkownik'] > 0){

if(isset($_POST['usun'])){
  	for ($i=0; $i < count($_POST['usun']); $i++) {
  		//echo "<p>{$_POST['usun'][$i]}</p>";
if (!@unlink(realpath("./obrazki")."/".$_POST['usun'][$i]))
{
echo ("<p>Nie można usunąć {$_POST['usun'][$i]}</p>");
$j=1;
break;
}
else
{
echo ("<p>Usunięto {$_POST['usun'][$i]}</p>");
$j=0;
}
 	}
 	echo ($j==0)?"<p><a href=\"" .str_replace('index.php','p',$full).$_SERVER['PATH_INFO']. "/\" style=\"border:solid 2px green;\" >Odśwież aby zobaczyć zmiany</a></p>":"<p><a href=\"" .str_replace('index.php','p',$full).$_SERVER['PATH_INFO']. "/\" style=\"border:solid 2px red;\" >Błąd Odśwież i spróbuj ponownie</a></p>";
 	echo "<hr/>";
}
	

	$c = new \ui\FormUI;
  $c->form(str_replace('index.php','p',$full).$_SERVER['PATH_INFO']."/",1,2,'style=border:1px solid black;');
	$c->input('submit', 'wykonaj','usuń');
	$c->tekst(" Usuń zaznaczone <br />");
}
        foreach($dirs as $file)
        {
                if (($file == '.')||($file == '..'))
                {
                } else {
                	$path_parts = pathinfo($tdir.'/'.$file);
					$pname = $path_parts["filename"];
					$ext = @$path_parts['extension'];
					@$extg = $ext === 'jpg' || $ext === 'JPG' || $ext === 'jpeg' || $extd === 'JPEG' || $ext === 'jpe' || $ext === 'JPE' ;
					$dir_mini = './mini/';
			if(!is_dir($file) && $extg){
					if (!file_exists($dir_mini.$file)) {
						resizeImage($tdir.'/'.$file, $dir_mini.$file, 150, 100);
					}
					list($width, $height) = @getimagesize($tdir.'/'.$file);
					if ($width > '640' && $height > '480') {
						resizeImage($tdir.'/'.$file, $tdir.'/'.$file, 640, 480);
					}
					
if(isset($_SESSION['uzytkownik']) && $_SESSION['uzytkownik'] > 0){   
	//$c->tekst ("<div style=\"background-image:url('$dirhost/mini/$file');\">");
	$c->tekst("<div>");
	$c->input('checkbox', 'usun[]',$file,null,array("style"=>"position:relative;bottom:145px;left:40px;border:dotted 2px black;margin:0px;padding:0px;width:20px;height:20px;"));//background-image:url(tlo.png);
	$c->tekst ("<a  href=\"$dirhost/obrazki/$file\" title=\"$pname' '$width x $height\"  rel=\"gb_imageset[GALERIA]\">
 		<img src=\"$dirhost/mini/$file\" alt=\"$pname' '$width x $height\"/>
 	</a></div>");

} else {
?>
 <div>
	<a  href="<?=$dirhost.'/obrazki/'.$file;?>"
 	 title="<?=$pname.' '.$width.'x'.$height;?>"  rel="gb_imageset[GALERIA]">
 		<img src="<?=$dirhost.'/mini/'.$file;?>" alt="<?=$pname.' '.$width.'x'.$height;?>"/>
 	</a>
 </div>
<?php	
}

 ?>

<?php
					
    }
	}

}
if(isset($_SESSION['uzytkownik']) && $_SESSION['uzytkownik'] > 0){
	$c->tekst("<br />");
	$c->input('submit', 'wykonaj','usuń');
	$c->tekst(" Usuń zaznaczone <br />");   
  $c->form();
  $c->pokaz();
  echo "<hr/>";
}		
clearstatcache();
}
function wgraj($dir='./obrazki',$max='50000'){
if(isset($_SESSION['uzytkownik']) && $_SESSION['uzytkownik'] > 0){
require_once 'ui.php';

$uploaddir = realpath($dir);
$host = $_SERVER['HTTP_HOST'];
$script = $_SERVER['SCRIPT_NAME'];
$full = "http://".$host.$script;
echo "<hr/>";
if (empty($_FILES)) {
        $b= new \ui\FormUI;
        $b->form(str_replace('index.php','p',$full).$_SERVER['PATH_INFO']."/",1,2,'style=border:1px solid black;');
        $b->tekst("Wybierz plik");
        $b->input('file', 'plik[]',NULL,'multi');
        $b->input('hidden', 'MAX_FILE_SIZE',$max);
        $b->input('submit', 'wgraj','wgraj plik');
        $b->form();
        $b->pokaz();
} else {
echo "<div>";
for ($i=0; $i < count($_FILES['plik']); $i++) { 

$plik_tmp = @$_FILES['plik']['tmp_name'][$i]; 
$plik_nazwa = @$_FILES['plik']['name'][$i]; 
$plik_rozmiar = @$_FILES['plik']['size'][$i]; 
$plik_error = @$_FILES['plik']['error'][$i]; 
$plik_type = @$_FILES['plik']['type'][$i];

if(is_uploaded_file($plik_tmp)) { 
     move_uploaded_file($plik_tmp, "$uploaddir/$plik_nazwa"); 
    echo "Plik: <strong>{$plik_nazwa}</strong> o rozmiarze 
    <strong>{$plik_rozmiar} bajtów typ $plik_type</strong> został przesłany na serwer! kod $plik_error<br />"; 
} 
}
echo "</div>";
echo "<hr/>";
}
//upload_max_filesize
}  
}

wgraj();    

usun('./mini');

mini('./obrazki');
?>
<br>
</div>

<?php 
namespace ui {
/**
 *  generator formularza wszystkie pola 
 *  użycie :
 *  start formularza :
 *  
 *  clasa->form( akcja , metoda przesyłu [1 do 2], typ przesyłu [1 do 3], inne wartości np: style=styl:coś tam; nie styl="coś tam" )
 * 
 * metoda przesyłu to:
 * 1 = GET
 * 2= POST
 * 
 * typ przesyłu to:
 * 1=text/plain
 * 2=multipart/form-data
 * 3=application/x-www-form-urlencoded
 * 
 *	koniec formularza to: clasa->form()
 * 
 * użycie input:
	$a->label('wymagany plik', id pola input); lub $a->label('wymagany plik');
	$a->input('text', 'linia','wartosc',NULL,'style=width:290px;height:20px;border:1px solid red;','id=test');
	$a->tekst('oto tekst ');
	$a->input('option', 'opcja','none=none|pl=polski|de=niemiecki|en=angielski|ch=chiński',1 = zaznaczony polski ,'style=width:200px;height:20px;border:1px solid green;background-color:brown;color:yellow;');
	$a->input('checkbox', 'check','checkone','zaznacz','style=width:20px;height:20px;border:1px solid red;');
 * pusty to $a->input('hidden',NULL,NULL,inne atrybuty)
 * dostępne:
  		 button
			 checkbox
			 file
			 hidden
			 image
			 password
			 radio
			 reset
			 submit
			 text
			 email
       option
       captha
  */
class UI {
	
	function __construct() {
	$this->data='';
	}
	private function inne($inne,$ile)
	{
		$atrybuty = "";
		if (is_array($inne)) {
		foreach ($inne as $atrybut => $wartosc) {
			if ($atrybut>=$ile) {
			if(!is_array($wartosc)) {
			$a=explode('=', $wartosc);
			list($klucz,$cecha)=$a;
			$atrybuty .= "$klucz=\"$cecha\" ";
			} else {
				foreach ($wartosc as $klucz => $cecha){
					$atrybuty .= "$klucz=\"$cecha\" ";	
				}	
			}
			}
		} 
		}
		return $atrybuty;	
	}

	function form($akcja=NULL,$metoda=1,$kodowanie=1){
		if ($akcja==null) {
			$this->data.="</form>\n";
		} elseif ($akcja!=NULL) {
			switch ($metoda) {
				case 1:
					$metoda="POST"; break;
					case 2:
					$metoda="GET"; break;
			}
			switch ($kodowanie) {
				case 1:
					$kodowanie='text/plain';
					break;
				case 2:
					$kodowanie='multipart/form-data';
					break;
				case 3:
					$kodowanie='application/x-www-form-urlencoded';
					break;
				default:
					$kodowanie='text/plain';
					break;
			}
			$this->data.="<form action=\"$akcja\" method=\"$metoda\" enctype=\"$kodowanie\" ".$this->inne(func_get_args(),3).">\n";
		}
	}
	function input($typ, $name, $wartosci=null,$dodatkowy=NULL)
	{
		$wartosc=($wartosci != NULL)? (is_array ($wartosci))? $wartosci:"value=\"$wartosci\" ":NULL;
		$name=($name != NULL)? "name=\"$name\" " : NULL;
		if ($typ=='textarea') 
			{
			$dodatkowy=NULL;
			$this->data.="<textarea $name ".$this->inne(func_get_args(),4).">$wartosci</textarea></label>\n";
		} elseif ($typ=='option' OR $typ=='select') {
			$i=0;
			$ii=0;
			$this->data.="<select $name".$this->inne(func_get_args(),4).">\n";
			$opcje=(is_array($wartosci))?$wartosci:explode('|', $wartosci);
				foreach ($opcje as $popcje => $podcechy) {
					
					
				if(is_array($wartosci)){
					$podopis = $popcje;
					$podwartosc = $podcechy;
				} else {
					$podcecha=explode('=', $podcechy);
					list($podopis,$podwartosc)=$podcecha;
				}
                    $selected=(strval($dodatkowy) == strval($podopis))?" selected=\"selected\"":'';
					$this->data.="<option value=\"$podopis\" $selected >$podwartosc</option>\n";
				}
			$this->data.="</select>\n";
		} else {
			/*

			 */
			 $lista_dodatkowa=explode('|', $dodatkowy);
			 @list($dodany,$wymagany) = $lista_dodatkowa;
			 switch ($typ) {
				 case 'image':
					 $dodatkowy="src=\"$dodatkowy\"";
					 break;
				 case 'file':
				($dodatkowy=='multi')?$dodatkowy="multiple=\"multiple\"" : $dodatkowy=NULL; break;
				case 'checkbox':
					($dodatkowy=='zaznacz')?$dodatkowy="checked=\"checked\"" : $dodatkowy=NULL; break;
				case 'radio':
					($dodatkowy=='zaznacz')?$dodatkowy="checked=\"checked\"" : $dodatkowy=NULL; break;
				 default:
					($dodatkowy=='wylacz')?$dodatkowy="disabled=\"true\"" : $dodatkowy=NULL;break;
			 }
			$this->data.="<input type=\"$typ\" $name $wartosc $dodatkowy ".$this->inne(func_get_args(),4)." />\n";
		}
	}

	function pole($tak=NULL,$legenda=NULL)	{
		if ($tak===1) {
			$this->data.="<fieldset ".$this->inne(func_get_args(),2)." >\n";
			($legenda==NULL)?:$this->data.="<legend>$legenda</legend>\n";
		} else {
			$this->data.="</fieldset>";
		}
		
	}
	function label($tekst=null, $dla=NULL) {
		switch ($tekst) {
			case !NULL:
				if ($dla!=NULL) {
					$this->data.="<label for=\"$dla\" ".$this->inne(func_get_args(),2).">$tekst</label>\n";
				} else {
					$this->data.="<label ".$this->inne(func_get_args(),2).">$tekst";
				}
				break;
			default:
				$this->data.="</label>\n";
				break;
		}
	}
	function tekst($tekst) {
		$this->data.=$tekst."\n";
	}
public function captha($name='icaptha', $alt="ERROR!!!", $dodatkowy=null)
{
    $host = $_SERVER['HTTP_HOST'];
    $script = $_SERVER['SCRIPT_NAME'];
    $path = (isset($_SERVER['PATH_INFO']))?$_SERVER['PATH_INFO']:null;
    $full = "http://".dirname($host.$script);
    $this->data.= '<img src="'.$full.'/obrazek.php" alt="'.$alt.'" id="'.$name.'" title="'.$name.'" /><br />';
    $this->data.= "<input type=\"text\" name=\"$name\" $dodatkowy ".$this->inne(func_get_args(),4)." />\n";
   
   // return true;
}
// funkcja weryfikacji formularza
function valid($type,$name){
    if ($type=="text" || $type=="textarea") {
        //  weryfikacja pola text
        $ciag_text = '/[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ0-9\-\_\.\(\)\,\:\@\!\?\%\s]$/';
        $ftext = preg_match($ciag_text,$name);
        if (!empty($name)&&$ftext==TRUE){
            return true;
        } else {
            return false;
        } 
    } elseif ($type=="email") {
    //  weryfikacja pola email
        $ciag = '/[_a-z0-9-]+(\.[_a-z0-9-]+)*@[_a-z0-9-]+(\.[_a-z0-9-]+)*(\.[a-z]{2,6})$/';
        $fmail = preg_match($ciag, $name);
        if ($fmail) {
            return true;
        } else {
            return false;
        }
    } elseif ($type=="url") {
    //  weryfikacja pola email
        $ciag = '#^(http|https)://.+(\.[_a-z0-9-]{2,5})$#';
        $fmail = preg_match($ciag, $name);
        if ($fmail) {
            return true;
        } else {
            return false;
        }
    } elseif ($type=="captha") {
        //  weryfikacja pola obrazka
        //@setcookie('spr',$_COOKIE['obr']);
        $ciag_num = '/[0-9]{4}?/';
        $fnum = preg_match($ciag_num,$name);
        if (is_numeric($name)&&$fnum) {
            if(md5($name) == $_SESSION["captha"] /*$_COOKIE['obr']*/){
								$_SESSION["captha"] = '';				
                @setcookie($name,'');
                return true;
            } else {
                return false;
        }} else {
        return FALSE;
    }}
}
// validacja pola
function input_valid($type,$name,$wartosci=null,$good='Good',$bad='Bad',$dodatkowy=null)
{
    if (!isset($_REQUEST[$name])) {
        self::input($type, $name, $wartosci);
    } else {    
        if (self::valid($type,$_REQUEST[$name])) {
        self::input($type, $name, $wartosci,$dodatkowy);
        self::tekst($good);
        } else {
        self::input($type, $name, $wartosci,$dodatkowy);
        self::tekst($bad);
        }
    }   
}
	function zapisz($plik=null) {
		if ($plik!='') {
			file_put_contents($plik, $this->data);
		}
		return $this->data;
	}
	public function pokaz() {
		echo $this->zapisz();
	}
} //koniec formgui

} // koniec Helper/gui
?>
<?php
namespace {

//header('Content-Type: text/html; charset=utf-8'); 
/*$a = new \UI\FormUI;
$a->form('ss',1,2,'style=width:400px;height:auto;border:1px solid gray;clear:both;','name=formtest');
$a->pole(1,'formularz');
$a->label('teraz test');
$a->input('textarea', 'text',NULL,NULL,'style=width:290px;height:150px;border:1px solid red;');
$a->label('test dla testu<br />','test');
$a->label('wymagany plik<br />','plik');
$a->input('text', 'linia','wartosc',NULL,'style=width:290px;height:20px;border:1px solid red;','id=test');
$a->input('text', 'linia1',NULL,NULL,'style=width:290px;height:20px;border:1px solid red;','id=test1');//,'required=required');
$a->input('text', 'linia2','wyłączony','wylacz','style=width:290px;height:20px;border:1px solid red;','id=test2');
$a->tekst('<br>oto tekst ');
$a->input('option', 'opcja','none=none|pl=polski|de=niemiecki|en=angielski|ch=chiński',1,'style=width:200px;height:20px;border:1px solid green;background-color:brown;color:yellow;');
$a->input('checkbox', 'check','checkone','zaznacz','style=width:20px;height:20px;border:1px solid red;');
$a->input('checkbox', 'check','checktwo',NULL,'style=width:20px;height:20px;border:1px solid red;');
$a->input('file', 'plik[]',NULL,'multi','style=width:290px;height:20px;border:1px solid red;','id=plik');
$a->input('hidden', 'MAX_FILE_SIZE','10M');
$a->input('image', NULL, NULL, 'a.jpg','style=width:60px;height:50px;border:2px solid brown;background-color:brown;float:right;');
$a->label('RMF','rmf');
$a->input('radio', 'stacja','rmf',NULL,'style=width:20px;height:20px;border:1px solid red;','id=rmf');
$a->label('ZET','zet');
$a->input('radio', 'stacja','zet',NULL,'style=width:20px;height:20px;border:1px solid red;','id=zet');
$a->label('EURO','euro');
$a->input('radio', 'stacja','euro','zaznacz','style=width:20px;height:20px;border:1px solid red;','id=euro');
$a->input('submit', NULL,'wyślij',NULL,'style=width:290px;height:20px;border:1px solid green;background-color:brown;');
$a->pole();
$a->form();
$a->pokaz();
//echo $a->zapisz('./test.html'); 
*/


}

?>
<?php
namespace Pliki {

    /**
     * kopiowanie, przenoszenie, usuwanie plików,
     * !!! dokończyć upload i nowe pliki !!!
     */
    class Akcje {

        function __construct() {
        }

        function usun($co) {
            $e = 0;
            if (!file_exists($co)) {
                return 1;
            }
            if (is_dir($co)) {
                foreach (glob($co . '/*') as $usun) {
                    if (is_dir($usun))
                        $this -> usun($usun);
                    else
                        $e = (unlink($usun)) ? 0 : 2;
                }
                $e = (rmdir($co)) ? 0 : 2;
            } else {
                $e = (unlink($co)) ? 0 : 2;
            }
            clearstatcache();
            return $e;
        }

        function kopiuj($co, $gdzie, $mode = "cp") {
            $e = 0;
            if (!file_exists($co)) {
                return 1;
            }
            if (file_exists($gdzie)) {
                return 2;
            }
            if (is_dir($co)) {
                $e = (mkdir($gdzie)) ? 0 : 3;
                $files = scandir($co);
                foreach ($pliki as $plik) {
                    if ($plik != "." && $plik != "..") {
                        $this -> kopiuj("$co/$plik", "$gdzie/$plik");
                    } else {
                        $data = file_get_contents("$co/$plik");
                        $e = (file_put_contents("$gdzie/$plik", $data)) ? 0 : 4;
                    }
                }
            } elseif (is_file($co)) {
                $data = file_get_contents($co);
                $e = (file_put_contents($gdzie, $data)) ? 0 : 4;
            }
            if ($mode === "mv") {
                $e = ($this -> usun($co)) ? 0 : 5;
            }
            clearstatcache();
            return $e;
        }

        function przenies($co, $gdzie) {
            return $this -> kopiuj($co, $gdzie, "mv");
        }

    } // class

}// end pliki

namespace Pliki {
    /**
     * chmod i jego form
     * !!! uporządkować formularz i przesyłane dane !!!
     */
    class Uprawnienia {

        function __construct() {
        }

        public function chmod_r($co, $mode, $w = 1) {
            $e = 0;
            if (!file_exists($co)) {
                return 1;
            }
            if ($w == 0) {
                if (is_dir($co)) {
                    $e = (@chmod($co, octdec($mode))) ? 0 : 2;
                    foreach (glob($co."/*") as $value) {
                        $this -> chmod_r($value, $mode);
                    }
                } else {
                    $e = (@chmod($co, octdec($mode))) ? 0 : 3;
                }
            } else {
                $e = (@chmod($co, octdec($mode))) ? 0 : 3;
            }
            return $e;
        }// chmod_r

            public function get_permission($value = '') {
            $perms = fileperms($value);

            if (($perms & 0xC000) == 0xC000) {
                // Socket
                $info['type'] = 's';
            } elseif (($perms & 0xA000) == 0xA000) {
                // Symbolic Link
                $info['type'] = 'l';
            } elseif (($perms & 0x8000) == 0x8000) {
                // Regular
                $info['type'] = '-';
            } elseif (($perms & 0x6000) == 0x6000) {
                // Block special
                $info['type'] = 'b';
            } elseif (($perms & 0x4000) == 0x4000) {
                // Directory
                $info['type'] = 'd';
            } elseif (($perms & 0x2000) == 0x2000) {
                // Character special
                $info['type'] = 'c';
            } elseif (($perms & 0x1000) == 0x1000) {
                // FIFO pipe
                $info['type'] = 'p';
            } else {
                // Unknown
                $info['type'] = 'u';
            }
 
            // Owner
            $info['owner']['r'] = (($perms & 0x0100) ? "checked=\"checked\"" : NULL);
            $info['owner']['w'] = (($perms & 0x0080) ? "checked=\"checked\"" : NULL);
            $info['owner']['x'] = (($perms & 0x0040) ? (($perms & 0x0800) ? NULL:"checked=\"checked\"") : (($perms & 0x0800) ? null : null));

            // Group
            $info['group']['r'] = (($perms & 0x0020) ? "checked=\"checked\"" : NULL);
            $info['group']['w'] = (($perms & 0x0010) ? "checked=\"checked\"" : NULL);
            $info['group']['x'] = (($perms & 0x0008) ? (($perms & 0x0400) ? NULL:"checked=\"checked\"") : (($perms & 0x0400) ? null : null));

            // World
            $info['any']['r'] = (($perms & 0x0004) ? "checked=\"checked\"" : NULL);
            $info['any']['w'] = (($perms & 0x0002) ? "checked=\"checked\"" : NULL);
            $info['any']['x'] = (($perms & 0x0001) ? (($perms & 0x0200) ? NULL:"checked=\"checked\"") : (($perms & 0x0200) ? null : null));

            return $info;
        }
public function chmodForm()
{
    $arr_mode=$_REQUEST['arr_mode'];
    $old=$_REQUEST['old'];
    $mode=$_REQUEST['mode'];
    $path = ($this->LINK) ? $this->TEN . $this->LINK : $this->TEN;
    $link= (is_dir($this->plik))?$this->plik:dirname($this->plik);
    $link.=DIRECTORY_SEPARATOR.$old;
    $get = $this->get_permission($link);
    $odczyt="{$this->lang['odczyt']}";
    $zapis="{$this->lang['zapis']}";
    $exec="{$this->lang['wykonywanie']}";
    $form=array(
    "<form action=\"$path\" method=\"POST\">",
    "<input type=\"checkbox\" name=\"arr_mode[]\" value=\"400\" {$get['owner']['r']} />",
    "<input type=\"checkbox\" name=\"arr_mode[]\" value=\"200\" {$get['owner']['w']} />",
    "<input type=\"checkbox\" name=\"arr_mode[]\" value=\"100\" {$get['owner']['x']} />",
    
    "<input type=\"checkbox\" name=\"arr_mode[]\" value=\"40\" {$get['group']['r']} />",
    "<input type=\"checkbox\" name=\"arr_mode[]\" value=\"20\" {$get['group']['w']} />",
    "<input type=\"checkbox\" name=\"arr_mode[]\" value=\"10\" {$get['group']['x']} />",
    
    "<input type=\"checkbox\" name=\"arr_mode[]\" value=\"4\" {$get['any']['r']} />",
    "<input type=\"checkbox\" name=\"arr_mode[]\" value=\"2\" {$get['any']['w']} />",
    "<input type=\"checkbox\" name=\"arr_mode[]\" value=\"1\" {$get['any']['x']} />",
    
    (!is_dir($link))?'':"{$this->lang['w']} {$this->lang['katalogu']}<input type=\"checkbox\" value=\"tak\" name=\"mode\" />",
    "<input type=\"hidden\"  name=\"old\" value=\"$old\" />",
    "<input type=\"submit\" value=\"{$this->lang['zmień']}\" />\n",
    "</form>"
    );
            if (isset($old)) {
                if (!isset($arr_mode)) {
                    $out = "<div style=\"width:160px; border: 1px solid black; padding:3px;\">";
                    $out .= $form[0];
                    $out .= "<b>{$this->lang['dla']} : \"$old\"</b>";
                    $out .= "<div>$form[1]$form[4]$form[7] $odczyt</div>";
                    $out .= "<div>$form[2]$form[5]$form[8] $zapis</div>";
                    $out .= "<div>$form[3]$form[6]$form[9] $exec</div>";
                    $out .= $form[10] . $form[11];
                    $out .= $form[12] . $form[13];
                    $out .= "</div>";
                } elseif (isset($arr_mode)) {
                    $i = 0;
                    foreach ($arr_mode as $key => $value) {
                        $i += $value;
                    }
                    $val = $i;
                }
                if ($mode == 'tak' and isset($arr_mode)) {
                    $zmien = $this -> chmod_r($link, $val, 'tak');
                } elseif ($mode != 'tak' and isset($arr_mode)) {
                    $zmien = $this -> chmod_r($link, $val);
                }
                if (isset($arr_mode)) {
                    if ($zmien) {
                        $out = "{$this->lang['zmieniono']} \"$link\" {$this->lang['na']} \"$val\"";
                        $out .= "&nbsp;<a href=\"$akcja\"><button>{$this->lang['odśwież']}</button></a>";
                    } else {
                        $out = "{$this->lang['nie']} {$this->lang['zmieniono']} \"$link\"";
                    }
                }
            }
            return $out;
        } // form

    } // class

}
namespace Pliki {
    /**
     * piliki tymczasowe
     */
    class Temp {
        function __construct($link = NULL) {
            $tmp = array_search('uri', @array_flip(stream_get_meta_data($GLOBALS[mt_rand()] = tmpfile())));
            $this -> tmp = $tmp;
            if ($link != NULL) {
                $this -> links = $link;
            }
        }

        public function wpisz($tekst = '', $tryb = NULL) {
            if ($this -> links != NULL AND $tryb == "d") {
                $bylo = file_get_contents($this -> links);
                if (strlen($bylo) != 0) {
                    $tekst = $bylo . $tekst . "\n";
                }
            }
            $this -> tekst = $tekst;
            file_put_contents($this -> tmp, $this -> tekst);
        }

        public function zapisz() {
            $out = file_get_contents($this -> tmp);
            if ($this -> links != NULL) {
                file_put_contents($this -> links, $this -> tekst);
                chmod($this -> links, 0666);
            }
            return $out;
        }

        public function __destruct() {
            foreach ($this as $key => $value) {
                unset($this -> $key);
            }
            clearstatcache();
            //ob_clean();
        }

        public function koniec() {
            fclose($this -> tmp);
            // to kasuje plik
            $this -> __destruct();

        }

    } // end class

}/// end namespase
/*
 namespace {
 $atryb=array(
 'style'=>'background-color:blue;width:500px;height:400px;'
 );
 $writer = new Helper\Temp('../Users/zend/test.html');
 $writer->wpisz(", AND AGAIN TMP FILE CONTENT!!! AGAIN");
 echo $writer->zapisz();
 $writer->koniec();

 }
 *
 */
namespace Pliki {
    class Obrazek {
        public function __construct($obrazek = NULL) {
            $this -> obrazek = $obrazek;
            $info = getimagesize($this -> obrazek);
            $this -> typ = $info[2];
            $this -> nowy_w = $info[0];
            $this -> nowy_h = $info[1];
            return TRUE;
        }

        public function __destruct() {
            foreach ($this as $key => $value) {
                unset($this -> $key);
            }
            clearstatcache();
        }

        private function zmien() {
            if (!extension_loaded('gd') && !extension_loaded('gd2')) {
                trigger_error("GD is not loaded", E_USER_WARNING);
                return false;
            }
            $nowa_nazwa = $this -> nowa_nazwa;
            switch ($this->typ) {
                case 1 :
                    $im = imagecreatefromgif($this -> obrazek);
                    break;
                case 2 :
                    $im = imagecreatefromjpeg($this -> obrazek);
                    break;
                case 3 :
                    $im = imagecreatefrompng($this -> obrazek);
                    break;
                default :
                    trigger_error('Unsupported filetype!', E_USER_WARNING);
                    break;
            }
            if ($this -> n_w == NULL and $this -> n_h == NULL) {
                $this -> n_w = $this -> nowy_w;
                $this -> n_h = $this -> nowy_h;
            }
            $obrazek_tmp = imagecreatetruecolor($this -> n_w, $this -> n_h);
            /* Check if this image is PNG or GIF, then set if Transparent*/
            if (($this -> typ == 1) OR ($this -> typ == 3)) {
                imagealphablending($obrazek_tmp, false);
                imagesavealpha($obrazek_tmp, true);
                $przezroczystosc = imagecolorallocatealpha($obrazek_tmp, 255, 255, 255, 127);
                imagefilledrectangle($obrazek_tmp, 0, 0, $this -> n_w, $this -> n_h, $przezroczystosc);
            }
            imagecopyresampled($obrazek_tmp, $im, 0, 0, 0, 0, $this -> n_w, $this -> n_h, $this -> nowy_w, $this -> nowy_h);
            switch ($this->typ) {
                case 1 :
                    imagegif($obrazek_tmp, $nowa_nazwa);
                    break;
                case 2 :
                    imagejpeg($obrazek_tmp, $nowa_nazwa);
                    break;
                case 3 :
                    imagepng($obrazek_tmp, $nowa_nazwa);
                    break;
                default :
                    trigger_error('Failed resize image!', E_USER_WARNING);
                    break;
            }
            imagedestroy($obrazek_tmp);
            clearstatcache();
            return $nowa_nazwa;
        }

        public function Rozmiar($w = 100, $h = 100, $force = 0) {
            if ($force == 1) {
                $nowy_w = $w;
                $nowy_h = $h;
            } else {
                if ($this -> nowy_w <= $w && $this -> nowy_h <= $h) {
                    $nowy_w = $this -> nowy_w;
                    $nowy_h = $this -> nowy_h;
                } else {
                    if ($w / $this -> nowy_w > $h / $this -> nowy_h) {
                        $nowy_w = $w;
                        $nowy_h = $this -> nowy_h * ($w / $this -> nowy_w);
                    } else {
                        $nowy_w = $this -> nowy_w * ($h / $this -> nowy_h);
                        $nowy_h = $h;
                    }
                }
                $nowy_w = round($nowy_w);
                $nowy_h = round($nowy_h);
            }
            $this -> n_w = $nowy_w;
            $this -> n_h = $nowy_h;
        }

        public function Zapisz($nowa_nazwa = NULL) {
            $this -> nowa_nazwa = $nowa_nazwa;
            header_remove();
            header('Content-type:' . @mime_content_type($this -> obrazek));
            $pokaz = $this -> zmien();
            clearstatcache();
            exit($pokaz);
        }

        public function Zamknij() {
        	clearstatcache();
            $this -> __destruct();
        }

    }

}
/*
 namespace {
 $obrazek = $_REQUEST['img'];
 $ini= parse_ini_file('../konfig/konfig.ini');
 $pokaz = new Helper\Obrazek($obrazek);
 $pokaz -> Rozmiar($ini['width'], $ini['height'], $ini['force']);
 $pokaz -> Zapisz();
 $pokaz -> Zamknij();
 }
 *
 */
namespace Pliki {
    /**
     * klasa pobierania pliku :)
     */
    class Pobierz {
        function __construct($plik = NULL) {
            //$plik = ($plik==NULL)?$_GET['pobierz']:$plik;
            if (file_exists($plik)) {
                header('Pragma: public');
                header('Content-Description: File Transfer');
                header('Content-Type:' . @mime_content_type($plik));
                header('Content-Disposition: attachment; filename=' . basename($plik));
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Content-Length: ' . filesize($plik));
                ob_clean();
                flush();
                readfile($plik);
                exit();
            }
        }

    }

}
/*
 namespace {
 $plik=$_GET['pobierz'];
 $a= new \Helper\Pobierz($plik);
 }
 *
 */
namespace Pliki {
    /**
     * kodowanie piliku ini konfig users.
     */
    class Kodowanie {

        function encode_this($string, $save) {
            $convert = base64_encode(strToHex(str_replace(array("\n", "="), array("@#$%", "*&^%"), $string)));
            if (isset($save)) {
                file_put_contents($save, $convert);
            }
            return $convert;
        }

        function decode_this($coded) {
            $convert = str_replace(array("@#$%", "*&^%"), array("\n", "="), hexToStr(base64_decode($coded)));
            return $convert;
        }

        function hexToStr($hex) {
            $string = '';
            for ($i = 0; $i < strlen($hex) - 1; $i += 2) {
                $string .= chr(hexdec($hex[$i] . $hex[$i + 1]));
            }
            return $string;
        }

        function StrToHex($string) {
            $hex = '';
            for ($i = 0; $i < strlen($string); $i++) {
                $hex .= dechex(ord($string[$i]));
            }
            return $hex;
        }

    } // koniec Kodowanie

}// helper koniec
namespace Pliki {
    /**
     *
     */
    class Wgraj {

        function __construct($skad, $miejsce_zapisu = null, $max = NULL, $ini = NULL) {
            $this -> skad = $skad;
            $wgrana_wielkosc = (int)@$_SERVER['CONTENT_LENGTH'];
            $ini = ($ini === NULL) ? realpath('./Wgraj.helper.gui.lang') : $ini;

            $alerty = parse_ini_file($ini, TRUE);
            $default = $alerty['lista']['default'];
            $lang = $alerty[$default];
            $miejsce_zapisu = ($miejsce_zapisu == NULL) ? $alerty['lista']['uploaddir'] : $miejsce_zapisu;
            $this -> miejsce_zapisu = $miejsce_zapisu;
            //$max = $this->Rozmiar_do_Byte($max);
            if ($max === NULL) {
                $max = $this -> Rozmiar_do_Byte($alerty['lista']['limit']);
            }
            if ($max > $this -> Rozmiar_do_Byte(ini_get('upload_max_filesize'))) {
                $max = $this -> Rozmiar_do_Byte(ini_get('upload_max_filesize'));
            }
            $this -> wgrana_wielkosc = $wgrana_wielkosc;
            $this -> maxi = $max;
            $this -> alerty = $lang;
            $pliki = $_FILES[$skad];
            $this -> nazwa = $pliki['name'];
            $this -> rozmiar = $pliki['size'];
            $this -> typ = $pliki['type'];
            $this -> tmp = $pliki['tmp_name'];
            $this -> blad = $pliki['error'];
        }

        function pokazRozmiar($filesize) {
            if (is_numeric($filesize)) {
                $decr = 1024;
                $step = 0;
                $prefix = array('Byte', 'KB', 'MB', 'GB', 'TB', 'PB');
                while (($filesize / $decr) > 0.9999) {
                    $filesize = $filesize / $decr;
                    $step++;
                }
                return round($filesize, 2) . ' ' . $prefix[$step];
            } else {
                return 'NaN';
            }
        }// pokaz rozmiar w string

        function Rozmiar_do_Byte($rozmiar) {
            $incr = 1024;
            $getBit = substr($rozmiar, strlen((int)$rozmiar));
            $getBit = (preg_match("/(b|byte)$/", strtolower($getBit))) ? substr($getBit, 0, -1) : $getBit;
            $lista = preg_match("/(K|M|G|T|P)$/", strtoupper($getBit), $match);
            switch ($match[0]) {
                case 'K' :
                    return (int)$rozmiar * $incr;
                    break;
                case 'M' :
                    return (int)$rozmiar * pow($incr, 2);
                    break;
                case 'G' :
                    return (int)$rozmiar * pow($incr, 3);
                    break;
                case 'T' :
                    return (int)$rozmiar * pow($incr, 4);
                    break;
                case 'P' :
                    return (int)$rozmiar * pow($incr, 5);
                    break;
                default :
                    return (int)$rozmiar;
                    break;
            }
        }

        function pokazBlad($nr) {
            return $this -> alerty['blad' . $nr];
        }

        function WgrajPliki($code = 0) {
            if ($this -> wgrana_wielkosc > $this -> maxi) {
                $arr_out = 5;
            } else {
                foreach ($this->nazwa as $num => $plik) {
                    if ($this -> blad[$num] !== UPLOAD_ERR_OK) {
                        $arr_out[] .= $this -> blad[$num];
                    } elseif ($this -> blad[$num] === UPLOAD_ERR_OK) {
                        if ($code === 1) {
                            $zapis = base64_encode($this -> nazwa[$num]);
                        } else {
                            $zapis = $this -> nazwa[$num];
                        }
                        if (move_uploaded_file($this -> tmp[$num], $this -> miejsce_zapisu . DIRECTORY_SEPARATOR . $zapis)) {
                            $arr_out[] .= $plik;
                        } else {
                            $arr_out[] .= $this -> blad[$num];
                        }
                    }
                }
            }
            return $arr_out;
        }

    }

}// koniec helper
/*
 namespace {
 echo "<hr>\n";

 echo htmlentities(encode_this(file_get_contents("../logindata.ini.php"), "./testcode"))."\n";
 echo "<hr>\n";
 echo htmlentities(decode_this(file_get_contents("./testcode")))."\n";

 echo "<hr>\n";
 }
 *
 */
namespace {

}
?>
<?php
interface ini_interface {
    //public $lines;
    //private $value;
    //public $test;
    public function __construct($value='');
    public function read($file);
    public function set($section,$key=NULL ,$value=NULL,$comment=NULL);    
    public function move($pointer,$section, $after=0);
    public function append($section,$key=NULL ,$value=NULL,$comment=NULL) ;   
    public function ren($from,$to);
    public function put($pointer,$new_section, $after=0);
    public function del($section,$key = null);
    public function get($section,$key);
    public function save();
    public function write($file="");
    public function __destruct();    
}
?>
<?php 
class ini implements ini_interface {
    public $lines;
    private $value;
    //public $test;
    public function __construct($value='')
    {
        ($value!=='')?$this->read($value):NULL;
        $this->value = $value;
    }
    public function read($file) {
        $this->lines = array();
		$i = 0;
        $j = 0;
        $section = '';
		if (!file_exists($file)) {
			trigger_error('Cannot open file not exist', E_USER_ERROR);
			return;
		} elseif (!parse_ini_file($file,TRUE)) {
			trigger_error('Cannot parse INI file ', E_USER_ERROR);
            return false;
		}
        foreach(file($file) as $line) {
            // comment or whitespace
            if(preg_match('/^\s*(;.*)?$/', $line , $comment)) {
            	@$this->lines[$comment[1]]['type']='comment';
                @$this->lines[$comment[1]]['info'] = $comment[1];
                @$this->lines[$comment[1]]['num'] = $j++;
				
            // section
            } elseif(preg_match('/\[(.*)\]/', $line, $match)) {
                $section = $match[1];
				@$this->lines[$section]['type']='entry';
				@$this->lines[$section]['info'] = $section;
                @$this->lines[$section]['num'] = $i++;
				
            // entry
            } elseif(preg_match('/^\s*(.*?)\s*=\s*(.*?)\s*$/', $line, $match)) {
            	$dwa = (preg_match('/^\s*(\'.*.\')\s*$/', $match[2])) ? substr($match[2], 1, -1) : $match[2] ;
				@$this->lines[$section]['data'][$match[1]] = $dwa;
            }
        }
    }

	public function set($section,$key=NULL ,$value=NULL,$comment=NULL)
	{
	    $i=0;
		if ($comment != NULL) {
			$this->lines[$section]['type'] = 'comment';
			$this->lines[$section]['info'] = "; $section";			
		} else {
		if ($key === NULL) {
			$this->lines[$section]['type'] = 'entry';
			$this->lines[$section]['info']=$section;
            $this->lines[$section]['num'] =$i++;
			//$this->lines[$section]['data'][$key]=$value;
			return ;
		} else {
			$this->lines[$section]['type'] = 'entry';
			$this->lines[$section]['info']=$section;
            $this->lines[$section]['num'] =$i++;
			($key!=NULL)?$this->lines[$section]['data'][$key]=$value:NULL;
		}
		}
	}
    public function append($section,$key=NULL ,$value=NULL,$comment=NULL)
    {
        $this->set($section,$key,$value,$comment);
    }
    
    public function move($pointer,$section, $after=1)
    {
    if (!isset($this->lines[$pointer]) || !isset($this->lines[$section])) {
        return FALSE;
    } 
    
    $tmp = array();
    $tmp[$section] =  $this->lines[$section];
    $this->del($section);
    $this->put($pointer,$section,$after);
    $this->lines[$section] =  $tmp[$section];
    
    }
    
    public function ren($from,$to)
    {
    if (!isset($this->lines[$from])) {
        return FALSE;
    } 
    $this->put($from, $to,1);
    $this->lines[$to]['data'] = $this->lines[$from]['data'];
    $this->del($from);
    }
    public function put($pointer,$new_section, $after=0)
    {
    if (isset($this->lines[$new_section]) && !isset($this->lines[$pointer])) {
        return FALSE;
    }
    $tmp = array();
    foreach ($this->lines as $section => $data) {
        switch ($data['type']) {
            case 'comment':
                $tmp[$section]['type'] = 'comment';
                $tmp[$section]['info'] = "$section"; 
                break;
            
            case 'entry':
                if (strval($section) == strval($pointer) && $after==0) {
                    $tmp[$new_section]['type'] = 'entry';
                    $tmp[$new_section]['info']=$new_section;
                    $tmp[$new_section]['num'] ='';// $i++;  
                    $tmp[$new_section]['data']=NULL;
                }
                $tmp[$section]['type'] = 'entry';
                $tmp[$section]['info']=$section;
                if (strval($section) == strval($pointer) && $after==1) {
                    $tmp[$new_section]['type'] = 'entry';
                    $tmp[$new_section]['info']=$new_section; 
                    $tmp[$new_section]['num'] ='';// $i++;  
                    $tmp[$new_section]['data']=NULL;
                }
                foreach ($data['data'] as $key => $value) {
                    $tmp[$section]['data'][$key]=$value;
                }
                break;
        }
        
    }
        $this->lines = $tmp;
        //return (array) $tmp;
    }
	public function del($section,$key = null)
	{
		if ($section == @$this->lines[$section]['info']) {
			if ($key != NULL && array_key_exists($key, $this->lines[$section]['data'])) {
				unset($this->lines[$section]['data'][$key]);
			} else {
				unset($this->lines[$section]);
			}
		} else {
			return FALSE;
		}
	}
	public function get($section,$key)
	{
	    
		if ($section == $this->lines[$section]['info']) {
			if (array_key_exists($key, $this->lines[$section]['data'])) {
				return (string) $this->lines[$section]['data'][$key];
			} else {
				return FALSE;
			}
        
		} else {
			return FALSE;
		}
	}
    public function save()
    {
	$text = '';
    foreach ($this->lines as $section => $data) {
        switch ($data['type']) {
            case 'comment':
                $text .= "{$data['info']}\n"; 
                break;
            case 'entry':
                $text .= "[{$data['info']}]\n";
                if(isset($data['data']) && $data['data'] !=NULL){
                foreach ($data['data'] as $key => $value) {
                    $text .= "$key = '$value'\n";
                }
                }
                break;
        }
    }
    return $text;
    }
    public function write($file="") {
    $file=($file=="")?$this->value:$file;
	$fp = fopen($file, 'w');

	fwrite($fp, $this->save());
	fclose($fp);
    }
public function __destruct()
{
	unset($this->lines);
    unset($this->value);
    //unset($this->saveINI);
    clearstatcache();
}
}

?>
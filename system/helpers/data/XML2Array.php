<?php
/**
 * @author ydk2
 */
class XML2Array {
    const JSON_OUT = 4;
    private $arg,$node,$tmpout;
    private $tmp = array();
    private $ToArray;
    private $xmldata;
    private $name;
    private $root;
    protected $i = 0;
    public $out;
    public $json,$xml,$array;
    function __construct($arg=NULL) {
        try {
        if ($arg != NULL) {
       If(is_array($arg)){
            $this->out = $this->ToXML($arg);
        } else {
            $this->out = $this->ToArray($arg);
        }
        }
                return 0;
        } catch (ErrorException $e) {
            trigger_error("'Caught exception: ',". $e->getMessage(),E_USER_ERROR);
            exit;
        }
    }
    function __destruct()
    {
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
        clearstatcache();
    }
    private function _getattr(array $attrlist=array())
    {
        $this->arg = NULL;       
                foreach ($attrlist as $attrname => $attrvalue) {
                    if ($attrname == 'style' && is_array($attrvalue)) {
                        $this->arg .= "style=\"";
                            foreach ($attrvalue as $stylename => $stylevalue) {
                            $this->arg .= "$stylename:$stylevalue;";
                            }
                        $this->arg .= "\" ";
                    } else $this->arg .= "$attrname=\"$attrvalue\" ";
            } // end foreach
           return (string) trim($this->arg);       
    }

    public function ToXML($arg) {
        $tmp = array(NULL,NULL,NULL,NULL);
        $tmparray = array();
        if(is_array($arg)){
        foreach ($arg as $key => $tagname) {
            $tmp[0] = $key;
        if (is_array($tagname)) {
        $i = 0;
        foreach ($tagname as $tagkey => $tagvalue) {
            if ($tagkey === "@attributes") {
                $tmp[1] = $this->_getattr($tagvalue);
            } // @attributes
           elseif ($tagkey !== "@attributes") {
                      if (!is_int($tagkey)) {
                        $tmp[3] .= call_user_func_array(array($this, 'ToXML'), array($tagname));//$this->a2x($tagvalue); 
                      } else {
                        $tmp[3] .= call_user_func_array(array($this, 'ToXML'), array($tagvalue));//$this->a2x($tagvalue);  
                      }
            }
        }
        } else {
          $tmp[3] .= $tagname;
        }
        
        } // end foreach 1
        $tmp[2] = ((trim($tmp[3])==NULL) /*&& ($this->node != '')*/)?"/>":">".$tmp[3]."</{$tmp[0]}>";
        $tmp[4] = (!isset($tmp[1]))?NULL:" ".trim($tmp[1]);
        $out = "<".trim($tmp[0].$tmp[4])."".$tmp[2];
        unset($tmp);
        } else {
            $out = $arg;
        }
        /*
        $this->i++;
        if (($this->i) > 200) {
            throw new ErrorException('Memory limit.');
        }
         * 
         */
        if ($this->out == null || $this->out == "") {
            $this->out = (string) $out;
            //$this->out();
        }
        return (string) $out;
    }
     public function ToArray($xml) {
     try {
             $this->ToArray = xml_parser_create ();
             xml_set_object($this->ToArray,$this);
             xml_set_element_handler($this->ToArray, "tagOpen", "tagClosed");
             xml_set_character_data_handler($this->ToArray, "tagData");
             $this->xmldata = xml_parse($this->ToArray,$xml );
             if(!$this->xmldata) {
                 throw new ErrorException("error: ".xml_error_string(xml_get_error_code($this->ToArray))." at line ".xml_get_current_line_number($this->ToArray));
             }
             xml_parser_free($this->ToArray);
             $out[$this->root] = $this->tmp[0];
            if ($this->out == null || $this->out == "") {
                $this->out = (array) $out;
                //$this->out();
            }
             return (array) $out;
             } catch (ErrorException $e) {
            //trigger_error("LITTLEXML ". $e->getMessage(),E_USER_NOTICE);
            //exit;    
            }
     }
     private function tagOpen($parser, $name, $attrs) {
        $this->name = $name;
        $tag=array("@name"=>strtolower($name),"@attributes"=>array_change_key_case($attrs));
        array_push($this->tmp,$tag);
    }
     private function tagData($parser, $tagData) {
        if(trim($tagData)) {
             if(isset($this->tmp[count($this->tmp)-1]['tagData'])) {
                 $this->tmp[count($this->tmp)-1][] .= $tagData;
             } 
             else {
                 $this->tmp[count($this->tmp)-1][] = $tagData;
             }
        }
     }
     private function tagClosed($parser, $name) {
         $a =$this->tmp[count($this->tmp)-1]['@name'];
         $this->root = $this->tmp[key($this->tmp)]['@name'];
         unset($this->tmp[count($this->tmp)-1]['@name']);
        $this->tmp[count($this->tmp)-2][][strtolower($a)] = array_change_key_case($this->tmp[count($this->tmp)-1]);
        
        array_pop($this->tmp);
     }
    public function out($mode=FALSE)
    {
        $out = $this->out;
        if (is_array($out)) {
        
        (!$mode)?:print_r($out);
        $this->array = $out;
        $this->xml = $this->ToXML($out);
        $this->json = json_encode($out); 
        return (array) $out;
        } else {
        (!$mode)?:print($out);
        $this->array = $this->ToArray($out);
        $this->xml = $out;       
        $this->json = json_encode($this->array); 
        return (string) $out; 
        }
    }
    public function close()
    {
        $this->__destruct();
        return 0;  
    }
}
?>
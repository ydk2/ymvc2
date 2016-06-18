<?php
namespace system\helpers;
/**
 * @author ydk2 
 * @version 0.1.1.4
 * @copyright 1992-2016 ydk2
 * 
*/
class array_paths {
    public $array;
    private $a;
    private $aa = FALSE;
    
    /**
     * @param array $array original array optional
     * {@internal new array object of array_paths class }}
     * @return array from given PATH to Indicates
     */
    function __construct($array = null) {
        if ($array != null) {
            $this -> array = $array;
            $this -> a = TRUE;
        } else
            unset($this -> a);
    }
    
    /**
     * @return none destroy class
     */
    function __destruct() {
        foreach ($this as $key => $value) {
            unset($this -> $key);
        }
    }
    
    /**
     * @param array $insert original array required
     * @param array $array original array optional
     * @return array 
     */    
    public function _unshift($insert, &$array = null) {
        $a = FALSE;
        if ($array == null) {
            $array = $this -> array;
            $a = TRUE;
        }
        array_unshift($array, $insert);
        if (isset($this -> a) && $a) {
            $this -> array = $array;
        }
        return $array;
    }
    
    /**
     * @param array $insert original array required
     * @param array $array original array optional
     * @return array 
     */
    public function _push($insert, &$array = null) {
        $a = FALSE;
        if ($array == null) {
            $array = $this -> array;
            $a = TRUE;
        }
        array_push($array, $insert);
        if (isset($this -> a) && $a) {
            $this -> array = $array;
        }
        return $array;
    }
    
    /**
     * @param string $needle original string required
     * @param int required position to put new element
     * @param array $haystack original array required
     * @return array 
     */
    public function _put($needle, $pos, $haystack) {
        $retval = array();
        $wejscie = array_slice($haystack, 0, $this -> key_num($pos, $haystack));
        $wyjscie = array_slice($haystack, $this -> key_num($pos, $haystack), count($haystack) + 1);
        $retval = $wejscie;
        array_push($retval, $needle);
        $retval = array_merge($retval, $wyjscie);
        return $retval;
    }

    /**
     * @param array $array original array optional
     * {@internal new array object of array_paths class }}
     * @return array from given PATH to Indicates
     */
    public function init($array = null) {
        if ($array != null) {
            $this -> array = $array;
            $this -> a = TRUE;
        } else
            unset($this -> a);
    }
        
    /**
     * Destroy function
     */
    public function close() {
        $this -> __destruct();
    }
    
    /**
     * @param array $array original array optional
     * @param array optional for recursive only
     * @return array with list all paths 
     */
    public function paths(array $array = NULL, array $path = array()) {
        if (isset($this -> a) && $array === NULL) {
            $array = $this -> array;
        }
        $result = array();
        foreach ($array as $key => $val) {
            $currentPath = array_merge($path, array($key));
            if (is_array($val)) {
                $result = array_merge($result, $this -> paths($val, $currentPath));
            } else {
                $result[] = join('/', $currentPath);
            }
        }
        return $result;
    }

    /**
     * @param string $search original string required
     * @param array optional for recursive only
     * @return int position of given key $search
     */
    public function key_num($search, array &$array) {
        foreach (array_keys($array) as $key => $value) {
            if (strval($value) == $search) {
                return (int)$key;
            }
        }
    }// end key_num

    /**
     * @param string $tag original string required
     * @param array optional for recursive only
     * @return string of found element as paths 
     */    
    public function search_key($tag, $array = null) {
        if ($array == null) {
            $array = $this -> array;
        }
        $output = array();
        foreach ($this->paths($array) as $key => $value) {
            $find = explode('/', $value);
            if (in_array($tag, $find)) {
                $output[] = $value;
            }
        }
        return $output;
    }

    /**
     * @param string $needle original string required
     * @param array $haystack original array required
     * @param array optional for search witn given $key_lookin
     * @return array of found element as paths 
     */
    public function array_search_recursive($needle, $haystack, $key_lookin = NULL) {
        $path = NULL;
        if (!empty($key_lookin) && array_key_exists($key_lookin, $haystack) && $needle === $haystack[$key_lookin]) {
            $path[] = $key_lookin;
        } else {
            foreach ($haystack as $key => $val) {
                if (is_scalar($val) && $val === $needle && empty($key_lookin)) {
                    $path[] = $key;
                    break;
                } elseif (is_array($val) && $path = call_user_func_array(array($this, 'array_search_recursive'), array($needle, $val, $key_lookin))) {
                    array_unshift($path, $key);
                    break;
                }
            }
        }
        return $path;
    }

    /**
     * @param string $searchKey original string required
     * @param string $searchValue original string required
     * @param array optional for recursive only
     * @return string of found element as paths 
     */
    public function search($searchKey, $searchValue, $array = null) {
        if ($array == null) {
            $array = $this -> array;
        }
        $path = implode('/', $this -> array_search_recursive($searchValue, $array, $searchKey));
        return $path;
    }

    /**
     * @param string $path path in the form 'root/child/etc...'
     * @param array $array original array optional
     * @return array from given PATH
     */
    public function get($path, &$array = null) {
        $a = FALSE;
        if ($array == null) {
            $array = $this -> array;
            $a = TRUE;
        }
        $current = &$array;
        foreach (explode('/', $path) as $key) {
            $current = &$current[$key];
        }
        if (isset($this -> a) && $a) {
            $this -> array = $array;
        }
        return $current;
    }

    /**
     * @param string $path original string required
     * @param string $new original string required
     * @param array $array original array optional
     * @return array 
     */
    public function cp($path, $new,$pos = 0, &$array = null) {
        $a = FALSE;
        if ($array == null) {
            $array = $this -> array;
            $a = TRUE;
        }
        $param = explode("/", $path);
        $end = array_pop($param);
        $first[$end] = $this->get($path,$array);
        //$this->set($new, $first, $array);
        try {
            if ($this->get($new,$array)) {
               $this->ins($new, $first, $array); 
            } else {
               $this->set($new, $first, $array);  
            }
        
        } catch(Exception $e) {
            echo 'Caught exception: ', $e -> getMessage(), "\n";
        }
        //$this->del($path,$array);
        if (isset($this -> a) && $a) {
            $this -> array = $array;
        }
        return $array;
    }

    /**
     * @param string $path original string required
     * @param string $new original string required
     * @param array $array original array optional
     * @return array 
     */
     public function move($path, $new, &$array = null) {
        $a = FALSE;
        if ($array == null) {
            $array = $this -> array;
            $a = TRUE;
        }
        $param = explode("/", $path);
        $end = array_pop($param);
        $first[$end] = $this->get($path,$array);
        //$this->set($new, $first, $array);
        try {
            if ($this->get($new,$array)) {
               $this->ins($new, $first, $array); 
            } else {
               $this->set($new, $first, $array);  
            }
        
        } catch(Exception $e) {
            echo 'Caught exception: ', $e -> getMessage(), "\n";
        }
        $this->del($path,$array);
        if (isset($this -> a) && $a) {
            $this -> array = $array;
        }
        return $array;
    }

    /**
     * @param string $path original string required
     * @param string $new original string required
     * @param array $array original array optional
     * @return array 
     */
     public function ren($path, $new, &$array = null) {
        $a = FALSE;
        if ($array == null) {
            $array = $this -> array;
            $a = TRUE;
        }
        $param = explode("/", $path);
        $end = array_pop($param);
        $first[$new] = $this->get($path,$array);
        //$this->insert($new, $first, $pos,$array);
        $this->set(implode("/",$param), $first,$array);
        //$this->del($path,$array);
        if (isset($this -> a) && $a) {
            $this -> array = $array;
        }
        return $array;
    }
             
    /**
     * @param string $path original string required
     * @param mixed $value original mixed required
     * @param array $array original array optional
     * @return array 
     */
    public function set($path, $value, &$array = null) {
        $a = FALSE;
        if ($array == null) {
            $array = $this -> array;
            $a = TRUE;
        }
        $param = explode("/", $path);
        $end = array_pop($param);
        $x = &$array;
        foreach ($param as $p) {
            $x = &$x[$p];
        }
        $x[$end] = $value;
        if (isset($this -> a) && $a) {
            $this -> array = $array;
        }
        return $x;
    }
    
    /**
     * @param string $path original string required
     * @param array $array original array optional
     * @return array 
     */
    public function del($path, &$array = null) {
        $a = FALSE;
        if ($array == null) {
            $array = $this -> array;
            $a = TRUE;
        }
        $param = explode("/", $path);
        $end = array_pop($param);
        $x = &$array;
        foreach ($param as $p) {
            $x = &$x[$p];
        }
        unset($x[$end]);
        if (isset($this -> a) && $a) {
            $this -> array = $array;
        }
        return $x;
    }
    
    /**
     * @param string $path original string required
     * @param mixed $insert original mixed required
     * @param array $array original array optional
     * @return array 
     */
    public function insert($path, $insert, $position, &$array = null) {
        $a = FALSE;
        if ($array == null) {
            $array = $this -> array;
            $a = TRUE;
        }
        $f = $this -> get($path, $array);
        if(count(array_keys($f))-1 > $position){
        $f = $this -> _put($insert, $position, $f);
        } else {
         $f =  $this->_push($insert,$f);
        }
        $this -> set($path, $f, $array);
        if (isset($this -> a) && $a) {
            $this -> array = $array;
        }
        return $array;
    }
   /**
     * @param string $path original string required
     * @param mixed $insert original mixed required
     * @param array $array original array optional
     * @return array 
     */
    public function ins($path, $insert, &$array = null) {
        $a = FALSE;
        if ($array == null) {
            $array = $this -> array;
            $a = TRUE;
        }
        
        $in = explode("/", $path);
        $right = array_pop($in);
        $left = implode("/", $in);
        $f = $this -> get($left, $array);
        $position = count(array_keys($f));
        foreach (array_keys($f) as $key => $value) {
            //echo "<p>$key $value</p>";
            if ($value == $right) {
                $position = $key-1;
                break;
            }
        }
        if(count(array_keys($f))-1 > $position){
        $f = $this -> _put($insert, $position, $f);
        } else {
         $f =  $this->_push($insert,$f);
        }
        $this -> set($left, $f, $array);
        if (isset($this -> a) && $a) {
            $this -> array = $array;
        }
        return $array;
    }

public function __get($name=NULL)
{
	echo '<pre>'; print_r ($name); echo '</pre>';
}


} // end array_paths
?>
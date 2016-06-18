<?php 
class users {
public $users;
public $retval;

private $login;
private $pass;

public function __construct($users_data) {
	$this->users = json_decode(file_get_contents($users_data),true);
	$this->retval = 100;
} // end construct
public function _login($login,$password){
	if (array_key_exists($_REQUEST[$login], $this->users)) {
    	if($this->users[$_REQUEST[$login]] == $_REQUEST[$password]){
			$this->users = 0;
		} else $this->users = 300;
	} else {
		$this->retval = 200;
	}
} // end _login
} // end class users

$a = new users(__DIR__."/users.json");
//print_r($a->users);
?>
<?php
// Convert a hex-string to binary-string (the way back from bin2hex)

function hex2bin($h)
  {
  if (!is_string($h)) return null;
  $r='';
  for ($a=0; $a<strlen($h); $a+=2) { $r.=chr(hexdec($h{$a}.$h{($a+1)})); }
  return $r;
  }

echo bin2hex('Łukasz'); // result: 48656c6c6f
echo hex2bin(bin2hex('Łukasz')); // result: Hello
?>

<?php
function strToHex($string){
    $hex = '';
    for ($i=0; $i<strlen($string); $i++){
        $ord = ord($string[$i]);
        $hexCode = dechex($ord);
        $hex .= substr('0'.$hexCode, -2);
    }
    return strToUpper($hex);
}
function hexToStr($hex){
    $string='';
    for ($i=0; $i < strlen($hex)-1; $i+=2){
        $string .= chr(hexdec($hex[$i].$hex[$i+1]));
    }
    return $string;
}

echo hexToStr(strToHex('Łukasz'));

?>
<!DOCTYPE HTML>
<html>
<head>
<meta content="text/html; charset=UTF-8" http-equiv="content-type"/>	
<link type="text/css" href="style.css" />
</head>
<body>
<div id="root">
<div id="form">
<form action="#" method="post" enctype="application/x-www-form-urlencoded">
	<label for="login">Login</label><input name="login" id="login" type="text" formnovalidate="formnovalidate" value=""/>
	<label for="password">Password</label><input type="password" name="password" id="password" value=""/>
	<input type="submit" value="Login" />
</form>	
</div>
<div id="content">
<pre>
<?php 
print_r($a->users);
?>
</pre>
</div>
</div>	
</body>	
</html>
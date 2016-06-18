<?php
namespace {
// errors codes
define('ERR_SUCCESS',0);
define('ERR_CVACCESS',1001);
define('ERR_CVENABLE',1003);
define('ERR_CVDISABLE',1002);
define('ERR_CVEXIST',1004);


define('ACCESS_ANY',1000);
define('ACCESS_USER',500);
define('ACCESS_MODERATOR',200);
define('ACCESS_EDITOR',100);
define('ACCESS_SYSTEM',10);
define('ACCESS_ADMIN',0);



define('VEXT','.php');
$url=(isset($_SERVER['HTTPS']))?'https://'.dirname($_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']):'http://'.dirname($_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']);
define('HOST_URL',$url);

define('SCONTROLLER','system/controller/');
define('SMODEL','system/models/');
define('SVIEW','system/views/');

define('MCONTROLLER','modules/controller/');
define('MMODEL','modules/models/');
define('MVIEW','modules/views/');

define('CONTROLLER','application/controller/');
define('MODEL','application/models/');
define('VIEW','application/views/');

define('LIBRARIES','/libraries/');
define('MODULES','/modules/');
define('PHP_LIBRARIES','/libraries/classes/');
define('PHP_MODULES','/modules/classes/');
define('VENDORS','/modules/vendors/');
define('TEMPLATES', 'templates/');
define('USES', '/data/config/uses.php');

define('DS', DIRECTORY_SEPARATOR);
define('DEBUG',null);
define('MEDIA_LEN',100);
define('INDEX', 'start');
setlocale(LC_ALL,'pl_PL.UTF-8');
define('DBPREFIX', '');
}
?>
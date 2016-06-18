<?php
            
			global $GLADIUS_DB_ROOT;
			global $ROOTPATH;
			$ROOTPATH = realpath('./');
            $GLADIUS_DB_ROOT = $ROOTPATH.'/database/';
			echo "<p>".$GLADIUS_DB_ROOT."</p>";
			echo "<p>".$ROOTPATH."</p>";
			chdir($GLADIUS_DB_ROOT);
			//die("THE END");
			require dirname($ROOTPATH).'/gladius/gladius.php';
            $G = new Gladius();
            if (!$G->Query('CREATE DATABASE testdb'))
                       echo "<b>".$G->errstr."</b>";

            $rs = $G->Query('SHOW DATABASES');           
			
			chdir(dirname($GLADIUS_DB_ROOT));
            // print the databases
            print_r($rs->GetArray());
			unset($G);
?>
<?php
            // include the database engine PHP code
            //include 'gladius/gladius.php';
            
            // creates the Gladius instance
            $db = new Gladius();

            // select the existing database
            $db->SelectDB('testdb') or die($db->errstr);
            
            // execute the SQL statement
            $rs = $db->Query('SELECT * FROM mytable');
            
            // retrieve the array of rows
            $data = $rs->GetArray();
            
            // print the raw arrays
            print_r($data);
?>
<?php
/** 
            // setup the databases folder
            global $GLADIUS_DB_ROOT;
            $GLADIUS_DB_ROOT = 'yourdirectory/databases/';

            // include Gladius
            require_once 'yourdirectory/gladius/gladius.php';

            // include adoDB lite
            require_once 'yourdirectory/adodb_lite/adodb.inc.php';
            
            // creates the adoDB connection using Gladius
            $db = ADONewConnection('gladius');

            // connect to the database, the first 3 parameters are ignored
            $connected = $db->Connect('', '', '', 'databasename');
            
            // print the result
            print_r($connected);
**/
?>
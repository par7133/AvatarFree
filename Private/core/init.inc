<?php

/**
 * Copyright 2021, 2024 5 Mode
 *
 * This file is part of Avatar Free.
 * 
 * Avatar Free is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Avatar Free is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.  
 * 
 * You should have received a copy of the GNU General Public License
 * along with Avatar Free. If not, see <https://www.gnu.org/licenses/>.
 *
 * init.inc
 * 
 * Avatar Free Initialization file.
 *
 * @author Daniele Bonini <my25mb@aol.com>
 * @copyrights (c) 2016, 2024, 5 Mode   
 */

//use fivemode\fivemode\Class;

error_reporting(E_ALL & ~ (E_WARNING | E_NOTICE | E_STRICT | E_DEPRECATED));  
ini_set('display_startup_errors',1);  
ini_set('display_errors',1);  
ini_set('log_errors',1); 


// CONFIGURATION
define("CONFIG_PATH", __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "config");

require CONFIG_PATH . DIRECTORY_SEPARATOR . "config.inc";
require CONFIG_PATH . DIRECTORY_SEPARATOR . "const.php.inc";

define("FUNCTIONS_PATH", __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "functions");

require FUNCTIONS_PATH . DIRECTORY_SEPARATOR . "func.various.inc";


mb_internal_encoding("UTF-8");


// ERROR HANDLING AND LOGGING

if (DEBUG) {
  error_reporting(E_ALL | E_STRICT);  
  ini_set('display_startup_errors',1);  
  ini_set('display_errors',1);
  ini_set('log_errors',1); 
} else {
  error_reporting(E_ALL & ~ (E_WARNING | E_NOTICE | E_STRICT | E_DEPRECATED));  
  ini_set('display_startup_errors',0);  
  ini_set('display_errors',0);  
  ini_set('log_errors',1); 
}

//Err::setDefaultHandlers();


// SHUTDOWN 

/**
 * Shutdown callback.
 * 
 * @return void
 */
function shutdownCallback() {
  
//Err::setLogOnlyHandlers();

/*  
  if (Cache::issetInstance()) {  
    //For non-persistent connections only
    //$cache = &Cache::getInstance();
    //$cache->close();

    Cache::unsetInstance();
  }
*/
  
}
register_shutdown_function("shutdownCallback");

// ERROR PARAMETERS

//errNo
//define("ERR_NO", substr(filter_input1(INPUT_GET, "errNo", FILTER_SANITIZE_MD5TOKEN), 0, 100));
//if (ERR_NO!==PHP_STR && !filter_var1(ERR_NO, FILTER_VALIDATE_ERRNO)) {
//  Err::trigger_error1(ERR::ERR_ERR, "Invalid error number: " . ERR_NO, __FILE__, __LINE__);
//}

//errKey
//define("ERR_KEY", array_search(ERR_NO, Err::$A_ERR_NO));

//errMsg
//define("ERR_MSG", substr(filter_input1(INPUT_GET, "errMsg", FILTER_SANITIZE_ERRMSG), 0, 200));

//errScript
//define("ERR_SCRIPT", substr(filter_input(INPUT_GET, "errScript", FILTER_SANITIZE_STRING), 0, 255));

//errLine
//define("ERR_LINE",  substr(filter_input(INPUT_GET, "errLine", FILTER_SANITIZE_NUMBER_INT), 0, 5));

//errStack
//define("ERR_STACK", substr(filter_input1(INPUT_GET, "errStack", FILTER_SANITIZE_STRING_WITHBR), 0, 2000));

?>

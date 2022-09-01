<?PHP
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
 * func.various.inc
 * 
 * Avar Free various useful functions.
 *
 * @author Daniele Bonini <my25mb@aol.com>
 * @copyrights (c) 2016, 2024, 5 Mode
 */

if (!function_exists("getResource0")) { 
/**
 * Get a resource translated 
 * 
 * @param string $resource the string to get translated
 * @param string $destLocale the destination locale
 * @param string $localeKey the locale key
 * @return string the translated resource    
 */  
function getResource0(string $resource, string $destLocale = "en-US", string $localeKey = "/".SCRIPT_FILENAME): string
{
  
  global $LOCALE;
  
  if ($destLocale === "en-US") {
    return $resource; 
  }    

  if (($LOCALE[$destLocale][$localeKey]['ping']??PHP_STR)==PHP_STR) {
    return $resource; 
  }    

  if (($LOCALE[$destLocale][$localeKey][$resource]??PHP_STR)==PHP_STR) {
    return $resource; 
  }    
  
  return $LOCALE[$destLocale][$localeKey][$resource];
}
}


/**
 * Replacement for echo with debug checking
 * 
 * @param boolean $debug_var a debug value, if true the echo will be executed 
 * @param list $args a variable argument list
 * @return void
 */
function echo_ifdebug($debug_var, ...$args) {
  if (!DEBUG || !$debug_var) {
    return;
  }
  foreach($args as $arg) {
    echo $arg;
  }
}

/**
 * Get an integer result for a division
 * 
 * @param mixed $a first operand
 * @param mixed $b second operand
 * @return int the integer result
 */
function intdiv_1($a, $b) {
  return ($a - $a % $b) / $b;
}

/**
 * Check if the number is odd
 * 
 * @param mixed $a first operand
 * @return bool if the number is odd, true/false
 */
function is_odd($a) {
  return ($a % 2) > 0;
}

/**
 * Check if the number is pair
 * 
 * @param mixed $a first operand
 * @return bool if the number is pair, true/false
 */
function is_pair($a) {
  return ($a % 2) === 0;
}

/**
 * Check if a variable is set with a default return
 * 
 * @param mixed $var the variable to check
 * @param mixed $default the default value
 * @return mixed the return value
 */
function isset1(&$var, $default=false) {
  if (isset($var)) {
    return $var;
  } else {
    return $default;
  }
}


if (!function_exists("fixMultipleFileUpload")) { 
/**
 * Fix multiple file uploaded array ($_FILE)
 * 
 * @param array $f the $_FILE array
 * @return array the array fixed
 */
function fixMultipleFileUpload(&$f): array
{
    $files = array();
    $count = count($f['name']);
    $keys = array_keys($f);
   
    for($i=0;$i<$count;$i++)
    {
        foreach($keys as $key)
        {
            $files[$i][$key] = $f[$key][$i];
        }
    }
    return $files;
}
}


/**
 * Replacement for var_dump with debug checking
 * 
 * @param boolean $debug_var a debug value, if true the var_dump will be executed 
 * @param list $args a variable argument list
 * @return void
 */
function var_dump_ifdebug($debug_var, ...$args) {
  if (!DEBUG || !$debug_var) {
    return;
  }
  foreach($args as $arg) {
    var_dump($arg);
  }
}


if (!function_exists("enableLinks")) { 
/**
 * Enable the links of the given text
 * 
 * @param string $text the text being parsed for links
 * @return the text with enabled links
 */
function enableLinks(string $text): string
{
  //return preg_replace("/(https?:\/\/)([\da-z\.-]+)\.([a-z\.]{2,8})(\/?.+)?/", "<a href='\\0' target=\"_blank\">\\0</a>", $text);
  return preg_replace("/(https?:\/\/)([\da-z\.-]+)\.([a-z\.]{2,8})(\/?[\da-zA-Z\-\?\/\&\#\=]+)?/i", "<a href='\\0' target=\"_blank\">\\0</a>", $text);
}  
}

if (!function_exists("HTMLencode")) { 
/**
 * Encode any HTML of a given string
 * 
 * @param string $s the string to encode
 * @param bool $withBR keep the BR tag, true/false
 * @return string the string encoded
 */
function HTMLencode(?string $s, bool $withBR = false): string 
{
    
  if (!isset($s)) {
    return PHP_STR;
  }
    
  $s = str_ireplace("&#39;", "'", $s); 
  $s = str_ireplace("&#34;", "\"", $s);
  $s = str_ireplace("\\n", "", $s);

  $s = htmlspecialchars($s, ENT_QUOTES |ENT_IGNORE | ENT_HTML5, "UTF-8");
  
  if ($withBR) {
    $s = str_ireplace(chr(10), PHP_BR, $s);
  }  
    
  $s = enableLinks($s);
  
  return $s;
} 
}


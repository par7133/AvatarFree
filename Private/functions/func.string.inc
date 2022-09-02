<?php

/**
 * Copyright (c) 2016, 2018, the Open Gallery's contributors
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither Open Gallery nor the names of its contributors 
 *       may be used to endorse or promote products derived from this software 
 *       without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDERS OR CONTRIBUTORS BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * func.string.inc
 * 
 * String related functions.
 *
 * @author Daniele Bonini <danielemi@hotmail.com>
 * @copyrights (c) 2016, 2018, the Open Gallery's contributors     
 * @license https://opensource.org/licenses/BSD-3-Clause 
 */


/**
 * Check if the given word is a contraction 
 * 
 * @param string $w the word being checked
 * @return bool if the word is a contraction, true/false
 */
function is_contraction(?string $w): bool 
{
  $retval = false;
  if (!isset($w)) {
    return $retval;
  }
  if ($w === mb_strtoupper($w)) {
    $retval = true;
  }
  return $retval;
}

/**
 * Check if the passed word is a given name 
 * 
 * @param string $w the word being checked
 * @return bool if the word is a given name, true/false
 */
function is_givenName(?string $w): bool 
{
  $retval = false;
  if (!isset($w)) {
    return $retval;
  }
  if (is_ucfirst($w) && !is_contraction($w)) {
    $retval = true;
  }
  return $retval;
}


/**
 * Check if the given string start with a capital letter
 * 
 * @param string $s the string being checked
 * @return bool if the string starts with a capital letter , true/false
 */
function is_ucfirst(?string $s): bool 
{
  $retval = false;
  if (!isset($s)) {
    return $retval;
  }
  if (ucfirst(mb_substr($s,0,1)) === mb_substr($s,0,1)) {
    $retval = true;
  }
  return $retval;
}

/**
 * Check if the letter is a vowel
 * 
 * @param char $letter the letter to check
 * @return bool if the letter is vowel, true/false
 */
function is_vowel(string $letter): bool 
{
  $vowels = ['a','e','i','o','u'];
  return in_array($letter, $vowels);
}

/**
 * Check if the given url is a valid Facebook page
 * 
 * Eg:
 * http://facebook.com/mrdanielebeta                                   
 * http://facebook.com/pg/makeiteasyforabird
 * 
 * @param string $url the url to check
 * @return bool if the url is Facebook url, true/false
 */
function isFacebookUrl(string $url): bool 
{
  $retval=false;
  $maxLength = 60;
  if (strlen($url)>60) {
    return $retval;    
  }
  $url= strtolower($url);
  $pattern1 = "/^http(s)?\:\/\/(www\.)?facebook\.com\/[\w\.]+$/";
  $pattern2 = "/^http(s)?\:\/\/(www\.)?facebook\.com\/pg\/[\w\.]+$/";
  if (preg_match($pattern1, $url) || preg_match($pattern2, $url)) {
    $retval=true;
  } else {
    $retval=false;
  }  
  return $retval;
}  

/**
 * Check if the given url is a valid domain url
 * 
 * Eg:
 * http://danielebonini.com
  * 
 * @param string $url the url to check
 * @return bool if the url is a valid domain url, true/false
 */
function isUrl(string $url): bool
{
  $retval=false;
  $maxLength = 45;
  if (strlen($url)>45) {
    return $retval;    
  }
  $url= strtolower($url);
  $pattern1 = "/^http(s)?\:\/\/(www\.)?\w+\.\w+$/";
  $pattern2 = "/^http(s)?\:\/\/(www\.)?\w+\.\w+.\w+$/";
  if (preg_match($pattern1, $url) || preg_match($pattern2, $url)) {
    $retval=true;
  } else {
    $retval=false;
  }  
  return $retval;
}  

/**
 * Check if the given url is a valid Youtube page
 * 
 * Eg:
 * http://youtube.com/watch?v=eeerwr24334 
 * 
 * @param string $url the url to check
 * @return bool if the url is Youtube url, true/false
 */
function isYoutubeUrl(string $url): bool 
{
  $retval=false;
  $maxLength = 50;
  if (strlen($url)>50) {
    return $retval;    
  }
  $url= strtolower($url);
  $pattern1 = "/^http(s)?\:\/\/(www\.)?youtube\.com\/watch\?v\=[\w]+$/";
  if (preg_match($pattern1, $url)) {
    $retval=true;
  } else {
    $retval=false;
  }  
  return $retval;
}  

/**
 * Test if a word is of a latin language
 * 
 * @param string  $word the string to test
 * @return bool  if $word is of a latin language, true/false
 */
function isLatinLang(string $word): bool 
{
  
  //$char = mb_substr($word, 0, 1);
  //return !preg_match("/[\x{31C0}-\x{31EF}\x{3300}-\x{33FF}\x{3400}-\x{4DBF}\x{4E00}-\x{9FFF}\x{F900}-\x{FAFF}\x{FE30}-\x{FE4F}]{1}/u", $char);
  
  $isNonLatinLang = preg_match("/^[\w-]+[\x{31C0}-\x{31EF}\x{3300}-\x{33FF}\x{3400}-\x{4DBF}\x{4E00}-\x{9FFF}\x{F900}-\x{FAFF}\x{FE30}-\x{FE4F}]+$/u", $word) ||
                    preg_match("/^[\x{31C0}-\x{31EF}\x{3300}-\x{33FF}\x{3400}-\x{4DBF}\x{4E00}-\x{9FFF}\x{F900}-\x{FAFF}\x{FE30}-\x{FE4F}]+$/u", $word) ||
                    preg_match("/^[\x{31C0}-\x{31EF}\x{3300}-\x{33FF}\x{3400}-\x{4DBF}\x{4E00}-\x{9FFF}\x{F900}-\x{FAFF}\x{FE30}-\x{FE4F}]+[\w-]+$/u", $word) ||
                    preg_match("/^[\w-]+[\x{31C0}-\x{31EF}\x{3300}-\x{33FF}\x{3400}-\x{4DBF}\x{4E00}-\x{9FFF}\x{F900}-\x{FAFF}\x{FE30}-\x{FE4F}]+[\w-]+$/u", $word);
  
  return !$isNonLatinLang;
}

/*
 * Check if the given string is specified in json format
 * 
 * @param string  $s the string being checked 
 * @return bool  if $s is in json format, true/false 
 */
function is_json(string $s): bool 
{
  if (left($s,1)==="{" && right($s,1)==="}" && stripos($s,":")!==false) {
    return true;    
  } else {
    return false;
  }
}

/*
 * Check if the given string is specified in json format
 * 
 * @param string  $s the string being checked 
 * @return bool  if $s is in json format, true/false 
 */
function is_listformat(string $s): bool
{
  $val = $s;
  $val = str_replace("'","\'", $val);
  $val = str_replace('"',"\"", $val);
  $cmd = "return is_array(".$val.");";
  $ret = eval($cmd);
  return $ret;    
}


function json_decode_from_db(string $json, bool $assoc = false) 
{
  $temp = $json;
  $temp = str_replace('\"', '"', $temp);
  $temp = str_replace("\'", "'", $temp);
  $temp = str_replace("\\\\", "\\", $temp);
  
  return json_decode($temp, $assoc);
}

/**
 * Left cut the given substring for the specified length 
 * 
 * @param string $string the string being cut on the left
 * @param int $length the length of the substring to return
 * @return string the resulting substring    
 */
function left(?string $string, int $length): string 
{
  if (!isset($string) || $string === PHP_STR) {
    return PHP_STR;
  }
  return mb_substr($string, 0, $length);
}

/**
 * Right cut the given string for the specified length 
 * 
 * @param string $string the string being cut on the right
 * @param int $length the length of the substring to return
 * @return string the resulting substring    
 */
function right(?string $string, int $length): string 
{
  if (!isset($string) || $string === PHP_STR) {
    return PHP_STR;
  }  
  return mb_substr($string, mb_strlen($string) - $length);
}

/**
 * Get the left word of the given sentence 
 * 
 * @param string $phrase  the sentence being processed
 * @return string the first word    
 */
function leftWord(?string $phrase): string 
{
  if (isset1($phrase, PHP_STR)===PHP_STR) {
    return PHP_STR;
  }  

  $aWords = explode(PHP_SPACE, $phrase);
  return $aWords[0]; 
}

/**
 * Get the right word of the given sentence 
 * 
 * @param string $phrase  the sentence being processed
 * @return string the last word    
 */
function rightWord(?string $phrase): string 
{
  if (isset1($phrase, PHP_STR)===PHP_STR) {
    return PHP_STR;
  }  

  $aWords = explode(PHP_SPACE, $phrase);
  return $aWords[count($aWords)-1];
}


/**
 * Return the number of words of the given phrase
 * 
 * @param string $phrase
 * @return int the number of words of the phrase
 */
function mb_str_word_count(string $phrase): int 
{
  $aWords = explode(PHP_SPACE, $phrase);
  return count($aWords);
}

/**
 * Finds the position of first occurrence of a string within another, 
 * result safe (excluding 0), case insensitive
 * 
 * @param string $string the string being searched
 * @param string $needle the string searched
 * @param int $offset the position in string to start the search 
 * @return mixed the position of the needle or False
 */
function mb_stripos1(string $string, string $needle, int $offset = 0) 
{
  return mb_stripos(PHP_TILDE . $string, $needle, $offset);
}  

/**
 * Normalize the case of the given text 
 * 
 * @param string $text text to case normalize
 * @return string the normalized text
 */
function str_case_normalize(?string $text): string 
{
  $retval = $text;
  
  if (!isset($text) || $text === PHP_STR) {
    return $retval;
  }
  
  $aWords = explode(PHP_SPACE, $text);
  
  foreach($aWords as & $word) {
    if (strtoupper(substr($word,0,1)) === substr($word,0,1)) {
      $word = ucfirst(strtolower($word));
    } else {  
      $word = strtolower($word);
    }  
  }
    
  $retval = implode(" ", $aWords);
  
  return $retval;
}  

/**
 * Clean a phase removing repeated spaces and trimming it  
 * 
 * @param string $string the string being cleaned
 * @return string the cleaned string
 */
function str_cleanphrase(string $string): string 
{
  //return trim(str_replace("  ", PHP_SPACE, str_replace("  ", PHP_SPACE, $string)));
  
  //hypen
  $retval = str_replace(" -", PHP_HYPHEN, $string);
  $retval = str_replace("- ", PHP_HYPHEN, $retval);
  $retval = ltrim($retval, PHP_HYPHEN);
  $retval = rtrim($retval, PHP_HYPHEN);
  //space
  $retval = trim(str_replace("  ", PHP_SPACE, str_replace("  ", PHP_SPACE, $retval)));
  
  return $retval;
}  

/**
 * Clean a phase removing repeated spaces and trimming it  
 * 
 * @param string $string the string being cleaned
 * @return string the cleaned string
 */
function str_cleanphrase_M(string $string): string 
{
  //return trim(str_replace("  ", PHP_SPACE, str_replace("  ", PHP_SPACE, $string)));
  
  //hypen
  $retval = str_replace(" -", PHP_HYPHEN, $string);
  $retval = str_replace("- ", PHP_HYPHEN, $retval);
  $retval = ltrim($retval, PHP_HYPHEN);
  $retval = rtrim($retval, PHP_HYPHEN);
  //axterix
  //$retval = trim(str_replace("**", "*", str_replace("**", "*", $retval)));
  $retval = str_replace("*", PHP_SPACE, $retval);
  //space
  $retval = trim(str_replace("  ", PHP_SPACE, str_replace("  ", PHP_SPACE, $retval)));
  
  return $retval;
}  

/**
 * Clean a phase removing the plurals  
 * 
 * @param string $string the string being cleaned
 * @return string the cleaned string
 */
function str_cleanplurals(string $string): string 
{
  $aWords = explode(PHP_SPACE, $string);
  
  foreach($aWords as &$word) {
    if (right($word,3)==="ies") {
      $word = left($word, strlen($word)-3) . "y";
    }  
    if (right($word,3)==="hes" || right($word,3)==="xes") {
      $word = left($word, strlen($word)-2);
    }  
    if (right($word,2)==="es") {
      $word = left($word, strlen($word)-2) . "e";
    }  
    if (right($word,2)!=="ss" && right($word,1)==="s") {
      $word = left($word, strlen($word)-1);
    }  
  }
  
  return implode(PHP_SPACE, $aWords);
}  

/**
 * Break the given phrase by a word separator
 * 
 * @param string $phrase the phrase being broken
 * @param string $word_separetor the word at which beginning break the phrase
 * @param string $retFirstPart the resulting broken first part of the phrase 
 * @param string $retReminder the remaining part of the phrase
 * @return void
 */
function str_phrasebrk(string $phrase, string $word_separetor, & $retFirstPart, & $retRemainder = null): void 
{
  $phrase = PHP_SPACE . $phrase . PHP_SPACE;
  $i = mb_stripos1($phrase, PHP_SPACE . $word_separetor . PHP_SPACE);
  if ($i) {
    $retFirstPart = trim(mb_substr($phrase, 0, $i));
    if (isset($retRemainder)) {
      $retRemainder = trim(mb_substr($phrase, $i));
    }
  } else {  
    $retFirstPart = trim($phrase);
    if (isset($retRemainder)) {
      $retRemainder = PHP_STR;
    }     
  }
}

/**
 * Return the given needle only if not already present in string
 * 
 * @param string $string
 * @param string $needle
 * @return string
 */
function str_place(string $string, string $needle): string  
{
   if (mb_stripos(PHP_TILDE . $string, $needle)) {
     return PHP_STR;
   } else {
     return $needle;
   }
}

/**
 * Replace a pattern in the given string
 * 
 * @param string $needle the pattern searched for
 * @param string $replace the replacement
 * @param string $string the string being searched
 * @param int $replacements the number of replacements to perform
 * @return string the replaced string
 */
function str_replace1(string $needle, string $replace, ?string $string, int $replacements = 1): string 
{
  if (!isset($string) || $replacements === 0) {
    return $string;
  }
  
  if ($replacements < 0 ) {
    $string = implode(PHP_SPACE, array_reverse(explode(PHP_SPACE, $string)));
    $replace = implode(PHP_SPACE, array_reverse(explode(PHP_SPACE, $replace)));
    $string = preg_replace("/$needle/i", $replace, $string, abs($replacements));
    $string = implode(PHP_SPACE, array_reverse(explode(PHP_SPACE, $string)));
  } else {
    $string = preg_replace("/$needle/i", $replace, $string, abs($replacements));
  }
  
  return $string;
}

/**
 * Reverse the words in the given phrase
 * 
 * @param string $string the string being reversed
 * @return string the resulting reversed string
 */
function str_phrase_reverse(string $string): string 
{
  settype($aWords, "array");
  $aWords = explode(PHP_SPACE, $string);
  $aWords = array_reverse($aWords);
  return implode(PHP_SPACE, $aWords);
}

/**
 * Finds the position of the first occurance of a word 
 * in the given string, result safe (excluding 0), case insensitive
 * 
 * @param string $phrase the phrase being searched
 * @param string $word the searched word
 * @param int $offset the position in string to start the search 
 * @return mixed the position of the searched word, otherwise false 
 */
function str_wordipos(string $phrase, string $word, int $offset = 0) 
{
  if ($offset<0) {
    $offset=0;
  }
  $word = strtolower($word);
  $phrase = strtolower($phrase);
  $aWords = explode(" ", $phrase);
  $max = count($aWords) - 1;
  $i = $offset; 
  while ($i <= $max) {
    $word2 = $aWords[$i];
    if ($word === $word2) {
      return $i + 1;
    }
    $i++;
  }
  return false;
}

/**
 * Remove duplicate words from a phrase
 * 
 * @param string $phrase the string being processed
 * @param bool $removeRightMost if remove the right-most duplicates, true/false
 * @return string the resulting string
 */
function str_word_unique(string $phrase, bool $removeRightMost = true) 
{
  settype($aWords, "array");
  $aWords = explode(PHP_SPACE, $phrase);
  if ($removeRightMost) {
    // Remove right-most duplicates from the given string..
    $aWords = array_unique($aWords);
  } else {
    // Remove left-most duplicates from the given string..
    $aWords = array_reverse($aWords);
    $aWords = array_unique($aWords);
    $aWords = array_reverse($aWords);
  }  
  return implode(PHP_SPACE, $aWords);
}  

/**
 * Short words by the given char limit
 * 
 * @param string $phrase the phrase being parsed 
 * @param int $wordLength the word limit to set
 * @return string  the resulting phrase
 */
function str_word_length(string $phrase, int $wordLength): string 
{
  $aWords = explode(PHP_SPACE, $phrase);
  foreach($aWords as & $word) {
    $word = mb_substr($word, 0, $wordLength);
  }
  return implode(PHP_SPACE, $aWords);
}

/**
 * Right trim a word from the given string
 * 
 * @param string $phrase the string being trimmed
 * @param array $aWords the words to remove
 * @return string the resulting right trimmed phrase 
 */
function rtrim_word(string $phrase, array $aWords): string 
{
  $retval = PHP_SPACE . $phrase . PHP_SPACE;
  
  foreach ($aWords as $word) {
    if (right($retval, mb_strlen($word) + 2) === (PHP_SPACE . $word . PHP_SPACE)) {
      $retval = left($retval, mb_strlen($retval) - (mb_strlen($word) + 1));
    }  
  }  
  
  return str_cleanphrase($retval);
}

/*
 * Convert a string in json format to a list
 * 
 * @param string $json the string being converted
 * @return string the resulting list
 */
function jsontolist($json) {
  
  $ret = $json;
  if (left($ret,1) === "{" && right($ret,1) === "}") {
    $ret = str_replace("{", "[", $ret);    
    $ret = str_replace("}", "]", $ret);
    $ret = str_replace(":", "=>", $ret);
  }
  return $ret;
  
}

/**
 * Trim a word from the given string
 * 
 * @param string $phrase the string being trimmed
 * @param array $aWords the words to remove
 * @return string the resulting trimmed phrase 
 */
function trim_word(string $phrase, array $aWords) {

  $retval = PHP_SPACE . $phrase . PHP_SPACE;
  
  foreach ($aWords as $word) {
    $retval = str_ireplace(PHP_SPACE . $word . PHP_SPACE, PHP_SPACE, $retval);
  }  
  
  return str_cleanphrase($retval);
}

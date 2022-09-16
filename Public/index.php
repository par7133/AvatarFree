<?php

/**
 * Copyright (c) 2016, 2024, 5 Mode
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
 * index.php
 * 
 * Avatar Free index file.
 *
 * @author Daniele Bonini <my25mb@aol.com>
 * @copyrights (c) 2016, 2024, 5 Mode     
 * @license https://opensource.org/licenses/BSD-3-Clause 
 */

require "../Private/core/init.inc";


// FUNCTION AND VARIABLE DECLARATIONS
$scriptPath = APP_SCRIPT_PATH;

// PARAMETERS VALIDATION

$url = strtolower(trim(substr(filter_input(INPUT_GET, "url", FILTER_SANITIZE_STRING), 0, 300), "/"));

switch ($url) {
  case "action":
    $scriptPath = APP_AJAX_PATH;
    define("SCRIPT_NAME", "action");
    define("SCRIPT_FILENAME", "action.php");     
    break;
  case "":
  case "home":   
    define("SCRIPT_NAME", "home");
    define("SCRIPT_FILENAME", "home.php");   

    $pattern = APP_DATA_PATH . DIRECTORY_SEPARATOR . "*";
    $aAvatarPaths = glob($pattern, GLOB_ONLYDIR);
    if (empty($aAvatarPaths)) {
      die("<br>&nbsp;No avatar exists yet: type in the url with your avatar name like http://" . $_SERVER['HTTP_HOST']. "/&lt;your avatar&gt;.<br>&nbsp;Login with the password and drag-n-drop here all the resources you want to associate to it. <br><br>&nbsp;Links by text and first dropped picture will be your avatar image.");
    } else {
      define("AVATAR_NAME", basename($aAvatarPaths[0]));
    }
    
    break;
  case "doc":
    $avatar = filter_input(INPUT_GET, "av", FILTER_SANITIZE_STRING);

    $AVATAR_PATH = APP_DATA_PATH . DIRECTORY_SEPARATOR . $avatar;
    
    $repo = filter_input(INPUT_GET, "re", FILTER_SANITIZE_STRING);
    switch ($repo) {
      case "cv":
        $REPO_PATH = $AVATAR_PATH . DIRECTORY_SEPARATOR . "cv";     
        break;
      default:
        die("unknown parma value:".$repo);
    }
    
    $doc = filter_input(INPUT_GET, "doc", FILTER_SANITIZE_STRING);
       
    $originalFilename = pathinfo($doc, PATHINFO_FILENAME);
    $destFilename = explode("|",$originalFilename)[1];
    $originalFileExt = pathinfo($doc, PATHINFO_EXTENSION);
    $fileExt = strtolower(pathinfo($doc, PATHINFO_EXTENSION));
    
    $docPath = $REPO_PATH . DIRECTORY_SEPARATOR . $doc;
       
    if (filesize($docPath) <= APP_FILE_MAX_SIZE) { 
      switch ($fileExt) {
        case "doc":
          header("Content-Type: application/msword");
          header('Content-Disposition: attachment; filename=' . $destFilename . '.doc');
          break;
        case "pdf":
          header("Content-Type: application/pdf");
          header('Content-Disposition: attachment; filename=' . $destFilename . '.pdf');
          break;
        default:
          die("unknown file extension.");
      }
      echo(file_get_contents($docPath));
    } else {
      die("doc size over app limits.");
    }  
    
    break;
  case "img":
    $avatar = filter_input(INPUT_GET, "av", FILTER_SANITIZE_STRING);

    $AVATAR_PATH = APP_DATA_PATH . DIRECTORY_SEPARATOR . $avatar;
    $GALLERY_PATH = $AVATAR_PATH . DIRECTORY_SEPARATOR . "gallery";     

    $pic = filter_input(INPUT_GET, "pic", FILTER_SANITIZE_STRING);
       
    $originalFilename = pathinfo($pic, PATHINFO_FILENAME);
    $originalFileExt = pathinfo($pic, PATHINFO_EXTENSION);
    $fileExt = strtolower(pathinfo($pic, PATHINFO_EXTENSION));
    
    if ($pic === APP_DEF_PROFILE_PIC) {
      $picPath = APP_PATH . DIRECTORY_SEPARATOR . "static" . $pic;
    } else {
      $picPath = $GALLERY_PATH . DIRECTORY_SEPARATOR . $pic;
    }  
       
    if (filesize($picPath) <= APP_FILE_MAX_SIZE) { 
      if ($fileExt = "jpg") {
        header("Content-Type: image/jpeg");
      } else {
        header("Content-Type: image/" . $fileExt);
      }  
      echo(file_get_contents($picPath));
    } else {
      die("picture size over app limits.");
    }  
    
    break;
  case "file":
    $avatar = filter_input(INPUT_GET, "av", FILTER_SANITIZE_STRING);
    $jar = (int)substr(filter_input(INPUT_GET, "jar", FILTER_SANITIZE_STRING),0,1);
    if ($jar >= 1 && $jar <= 3) {
    } else {
      die("jar parameter error.");
    }
    
    $AVATAR_PATH = APP_DATA_PATH . DIRECTORY_SEPARATOR . $avatar;
    $JAR_PATH = $AVATAR_PATH . DIRECTORY_SEPARATOR . "magicjar" . $jar;     

    $fileName = filter_input(INPUT_GET, "fn", FILTER_SANITIZE_STRING);
       
    $originalFilename = pathinfo($fileName, PATHINFO_FILENAME);
    $orioriFilename = explode("|", $originalFilename)[1];
    $originalFileExt = pathinfo($fileName, PATHINFO_EXTENSION);
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
    $filePath = $JAR_PATH . DIRECTORY_SEPARATOR . $fileName;
       
    if (filesize($filePath) <= APP_FILE_MAX_SIZE) { 
      header("Content-Type: unknown");
      header("Content-Disposition: attachment; filename=" . $orioriFilename . ".$fileExt");
      echo(file_get_contents($filePath));
    } else {
      die("file size over app limits.");
    }  
    
    break;    
  default:
    define("SCRIPT_NAME", "home");
    define("SCRIPT_FILENAME", "home.php");   

    define("AVATAR_NAME", $url);

    break;
}

if (SCRIPT_NAME==="err-404") {
  header("HTTP/1.1 404 Not Found");
}  

require $scriptPath . "/" . SCRIPT_FILENAME;

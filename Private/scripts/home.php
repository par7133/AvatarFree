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
 * home.php
 * 
 * Home of Avatar Free.
 *
 * @author Daniele Bonini <my25mb@aol.com>
 * @copyrights (c) 2016, 2024, 5 Mode
 */

 // CONSTANTS AND VARIABLE DECLARATION      
 $CURRENT_VIEW = PUBLIC_VIEW;
 
 $CUDOZ = 1;
 
 $AVATAR_PATH = APP_DATA_PATH . DIRECTORY_SEPARATOR . AVATAR_NAME;

 $CV_PATH = $AVATAR_PATH . DIRECTORY_SEPARATOR . "cv";      
 $FRIENDS_PATH = $AVATAR_PATH . DIRECTORY_SEPARATOR . "friends";      
 $BLOG_PATH = $AVATAR_PATH . DIRECTORY_SEPARATOR . "blog";      
 $GALLERY_PATH = $AVATAR_PATH . DIRECTORY_SEPARATOR . "gallery";      
 $TRES1_PATH = $AVATAR_PATH . DIRECTORY_SEPARATOR . "tres1";      
 $TRES2_PATH = $AVATAR_PATH . DIRECTORY_SEPARATOR . "tres2";
 $TRES3_PATH = $AVATAR_PATH . DIRECTORY_SEPARATOR . "tres3";
 
 $profilePic = APP_DEF_PROFILE_PIC;
 
 
 // PAGE PARAMETERS
 $password = filter_input(INPUT_POST, "Password");
 if ($password !== PHP_STR) {	
   $hash = hash("sha256", $password . APP_SALT, false);

   if ($hash !== APP_HASH) {
     $password=PHP_STR;	
   }	 
 } 
 if ($password !== PHP_STR) {
   $CURRENT_VIEW = ADMIN_VIEW;
 } else {
   $CURRENT_VIEW = PUBLIC_VIEW;
 } 

 
 function uploadNewRes() {

   global $AVATAR_PATH;
   global $CV_PATH;      
   global $FRIENDS_PATH;      
   global $BLOG_PATH;      
   global $GALLERY_PATH;      
   global $TRES1_PATH;      
   global $TRES2_PATH;
   global $TRES3_PATH;

   //echo_ifdebug(true, "AVATAR_PATH#1=");
   //echo_ifdebug(true, $AVATAR_PATH);
   
   //if (!empty($_FILES['files'])) {
   if (!empty($_FILES['filesdd']['tmp_name'][0])) {
	   
     //no file uploaded
     //$uploads = (array)fixMultipleFileUpload($_FILES['files']);
     //if ($uploads[0]['error'] === UPLOAD_ERR_NO_FILE) {
       $uploads = (array)fixMultipleFileUpload($_FILES['filesdd']);
     //}   
     //if ($uploads[0]['error'] === PHP_UPLOAD_ERR_NO_FILE) {
     //  echo("WARNING: No file uploaded.");
     //  return;
     //} 

     $google = "abcdefghijklmnopqrstuvwxyz";
     if (count($uploads)>strlen($google)) {
       echo("WARNING: Too many uploaded files."); 
       return;
     }

     $i=1;
     foreach($uploads as &$upload) {
		
       switch ($upload['error']) {
       case PHP_UPLOAD_ERR_OK:
         break;
       case PHP_UPLOAD_ERR_NO_FILE:
         echo("WARNING: One or more uploaded files are missing.");
         return;
       case PHP_UPLOAD_ERR_INI_SIZE:
         echo("WARNING: File exceeded INI size limit.");
         return;
       case PHP_UPLOAD_ERR_FORM_SIZE:
         echo("WARNING: File exceeded form size limit.");
         return;
       case PHP_UPLOAD_ERR_PARTIAL:
         echo("WARNING: File only partially uploaded.");
         return;
       case PHP_UPLOAD_ERR_NO_TMP_DIR:
         echo("WARNING: TMP dir doesn't exist.");
         return;
       case PHP_UPLOAD_ERR_CANT_WRITE:
         echo("WARNING: Failed to write to the disk.");
         return;
       case PHP_UPLOAD_ERR_EXTENSION:
         echo("WARNING: A PHP extension stopped the file upload.");
         return;
       default:
         echo("WARNING: Unexpected error happened.");
         return;
       }
      
       if (!is_uploaded_file($upload['tmp_name'])) {
         echo("WARNING: One or more file have not been uploaded.");
         return;
       }
      
       // name	 
       $name = (string)substr((string)filter_var($upload['name']), 0, 255);
       if ($name == PHP_STR) {
         echo("WARNING: Invalid file name: " . $name);
         return;
       } 
       $upload['name'] = $name;
       
       // fileType
       $fileType = substr((string)filter_var($upload['type']), 0, 30);
       $upload['type'] = $fileType;	 
       
       // tmp_name
       $tmp_name = substr((string)filter_var($upload['tmp_name']), 0, 300);
       if ($tmp_name == PHP_STR || !file_exists($tmp_name)) {
         echo("WARNING: Invalid file temp path: " . $tmp_name);
         return;
       } 
       $upload['tmp_name'] = $tmp_name;
       
       //size
       $size = substr((string)filter_var($upload['size'], FILTER_SANITIZE_NUMBER_INT), 0, 12);
       if ($size == "") {
         echo("WARNING: Invalid file size.");
         return;
       } 
       $upload["size"] = $size;

       $tmpFullPath = $upload["tmp_name"];
       
       $originalFilename = pathinfo($name, PATHINFO_FILENAME);
       $originalFileExt = pathinfo($name, PATHINFO_EXTENSION);
       $fileExt = strtolower(pathinfo($name, PATHINFO_EXTENSION));

       $date = date("Ymd-His");
       $rnd = mt_rand(1000000000, 9999999999);    
       
       if ($originalFileExt!==PHP_STR) {
         $destFileName = $date . "-" . $rnd . substr($google, $i-1, 1) . "|" . str_replace(" ", "_", $originalFilename) . ".$fileExt";
       } else {
         return; 
       }	   

       //$CV_PATH = APP_DATA_PATH . DIRECTORY_SEPARATOR . "cv";      
       //$FRIENDS_PATH = APP_DATA_PATH . DIRECTORY_SEPARATOR . "friends";      
       //$BLOG_PATH = APP_DATA_PATH . DIRECTORY_SEPARATOR . "blog";      
       //$GALLERY_PATH = APP_DATA_PATH . DIRECTORY_SEPARATOR . "gallery";      
       
       switch ($fileExt) {
         case "doc":
         case "docx":
         case "pdf":
           $destPath = $CV_PATH;
           break;
         case "txt":
           $destPath = $BLOG_PATH;
           break;
         case "png":
         case "jpg":
         case "jpeg":
         case "gif":
         case "webp":
           $destPath = $GALLERY_PATH;
           break;
         default:
           $destPath = $TRES1_PATH;
           break;
       }
       $destFullPath = $destPath . DIRECTORY_SEPARATOR . $destFileName;

       if (file_exists($destFullPath)) {
         echo("WARNING: destination already exists");
         return;
       }	   

       //echo_ifdebug(true, "AVATAR_PATH#2=");
       //echo_ifdebug(true, $AVATAR_PATH);
       //echo_ifdebug(true, "is_readable(AVATAR_PATH)=");
       //echo_ifdebug(true, is_readable($AVATAR_PATH));
       
       if (!is_readable($AVATAR_PATH)) {
         mkdir($AVATAR_PATH, 0777); 
       }
       
       if (!is_readable($destPath)) {
         mkdir($destPath, 0777); 
       }
       
       $pattern = $destPath . DIRECTORY_SEPARATOR . "*" . "|" . str_replace(" ", "_", $originalFilename) . ".$fileExt";
       $aExistingPaths = glob($pattern);
       if (!empty($aExistingPaths)) {
         continue;
       }
       
       copy($tmpFullPath, $destFullPath);

       // Cleaning up..
      
       // Delete the tmp file..
       unlink($tmpFullPath); 
       
       $i++;
        
     }	 
   }
 }

 function writeFriends() {
   
   global $FRIENDS_PATH; 
   
   $destPath = $FRIENDS_PATH;
   
   $s = filter_input(INPUT_POST, "f", FILTER_SANITIZE_STRING);
   if ($s != PHP_STR) {
   //echo($s);
   //exit(0);
     $friends=explode("|", $s);
     
     if (!is_readable($destPath)) {
       mkdir($destPath, 0777); 
     }
     
     foreach($friends as $friend) {
       $a = explode("://",$friend);
       $s = $a[1];
       $a = explode("/", $s); 
       $friendName = $a[0] . ".txt";
       
       file_put_contents($destPath . DIRECTORY_SEPARATOR . $friendName, $friend);
     }
     
   }  
 }
 
 function grabProfileImage() {
   
   global $GALLERY_PATH;
   
   $pattern = $GALLERY_PATH . DIRECTORY_SEPARATOR . "*";
   $aImagePaths = glob($pattern);
   if (isset($aImagePaths[0])) {
     $retval = basename($aImagePaths[0]);
   } else {
     $retval = null;
   }
   return $retval;
   
 }
 
 function startApp() {
   global $CURRENT_VIEW;
   global $profilePic;
   
   if ($CURRENT_VIEW == ADMIN_VIEW) {
   
     uploadNewRes();
   
     writeFriends();
  
   }
     
   $profilePic = grabProfileImage() ?? APP_DEF_PROFILE_PIC;
   //echo("profile pic=" . $profilePic);
  
 }  
 startApp();
 
?>

<!DOCTYPE html>
<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta name="viewport" content="width=device-width, initial-scale=1"/>
   
  <!--<?PHP echo(APP_LICENSE);?>-->  
  
  <title>Avatar Free: everyone its social presence.</title>

  <link rel="shortcut icon" href="/favicon.ico" />

  <meta name="description" content="Welcome to Avatar Free! Let everyone own its social presence."/>
  <meta name="keywords" content="Avatar Free,social,presence,avatarfree.org,on,premise,solution"/>
  <meta name="robots" content="index,follow"/>
  <meta name="author" content="5 Mode"/>
  
  <script src="/js/jquery-3.6.0.min.js" type="text/javascript"></script>
  <script src="/js/sha.js" type="text/javascript"></script>
  <script src="/js/common.js" type="text/javascript"></script>  
    
  <link href="/css/style.css?r=<?PHP echo(time());?>" type="text/css" rel="stylesheet">
  
  <link href="/css/bootstrap.min.css" type="text/css" rel="stylesheet">
   
</head>
  
<?PHP if ($CURRENT_VIEW == ADMIN_VIEW): ?>    
  
  <body style="background:url('/res/bg1.jpg') no-repeat; background-size: cover; background-attachment: fixed; background-position: center;">

   <div style="width:100%;height:fit-content;position:fixed;background:yellow;color:darkorange;text-align:center;cursor:pointer;" onclick="showHowTo();"><br>How-to: Manage your avatars in Avatar Free<br><br></div> 

  <form id="frmUpload" role="form" method="post" action="/<?PHP echo(AVATAR_NAME);?>" target="_self" enctype="multipart/form-data">  
    
  <div class="dragover" style="width:100%;height:100%;border:0px solid red;" dropzone="copy">  
    
    <img id="picavatar" src="/img?av=<?PHP echo(AVATAR_NAME);?>&pic=<?PHP echo($profilePic);?>" align="middle" style="position:absolute;width:255px;height:255px;border-radius: 90%; display:none;">  
  
    <input type="hidden" id="a" name="a">    
    <input type="hidden" id="f" name="f">  
    
  </div>  

 <input type="hidden" id="Password" name="Password" value="<?PHP echo($password);?>"> 
    
 </form>   
           
  <div id="footerCont">&nbsp;</div>
  <div id="footer"><span style="background:#FFFFFF; opacity:0.7;">&nbsp;&nbsp;<a class="aaa" href="dd.html">Disclaimer</a>.&nbsp;&nbsp;A <a href="http://5mode.com" class="aaa">5 Mode</a> project and <a href="http://demo.5mode.com" class="aaa">WYSIWYG</a> system. Some rights reserved.</span></div>
           
<?PHP else: ?>          

  <body style="background:#dadada no-repeat; background-size: cover; background-attachment: fixed; background-position: center;">

   <div style="width:100%;height:fit-content;position:fixed;background:yellow;color:darkorange;text-align:center;cursor:pointer;z-index:99999;" onclick="showHowTo();"><br>How-to: Manage your avatars in Avatar Free<br><br></div> 

   <form id="frmUpload" role="form" method="post" action="/<?PHP echo(AVATAR_NAME);?>" target="_self" enctype="multipart/form-data">  
   
   <div id="title" style="position:relative;top:80px;left:50px;width:100%;float:left;font-size:25px;font-family:'Press Start 2P';border:0px solid blue;"> 
        <div id="cudoz" style="width:255px;height:255px;float:left;border:0px solid yellow;">
            <img id="picavatar" src="/img?av=<?PHP echo(AVATAR_NAME);?>&pic=<?PHP echo($profilePic);?>" align="middle" style="width:255px;height:255px;border-radius: 90%;">
        </div>  
        <div id="cudoz" style="width:250px;height:255px;padding-top:122px;float:left;border:0px solid yellow;vertical-align:middle;">
          &nbsp;<?PHP echo(strtoupper(AVATAR_NAME));?>&nbsp;&nbsp;&nbsp;
        </div>  
        <div id="cudoz" style="width:250px;height:255px;padding-top:116px;float:left;border:0px solid green;vertical-align:middle;">
        <?PHP for ($i=1;$i<=$CUDOZ;$i++): ?>
             <img id="cudozentry<?PHP echo($i);?>" src="/res/chicca_it.png" style="float:left;width:46px">    
        <?PHP endfor; ?>
        <?PHP for ($i=$CUDOZ+1;$i<=5;$i++): ?>
             <img id="cudozentry<?PHP echo($i);?>" src="/res/chiccadis.png" style="float:left;width:46px">    
        <?PHP endfor; ?>               
         </div> 

        <div id="cvs" style="float:right;border:3px solid darkgray;border-radius:4px;padding:4px;background:#dadada;font-size:20px;font-family:'Press Start 2P';">  
          
                   <div style="float:left;width:47px;margin-top:20px;margin-left:7px;">CV</div>
          
       <?PHP
       $pattern = $CV_PATH . DIRECTORY_SEPARATOR . "*";
       $aFilePaths = glob($pattern);
       if (empty($aFilePaths)): ?>
                  <img src="/res/wordicondis.png" style="float:left;width:64px">&nbsp;&nbsp;<img src="/res/pdficondis.png" style="float:left;width:64px">
            <?PHP else: ?>
                    <?PHP
         $CUDOZ++;
         $pattern = $CV_PATH . DIRECTORY_SEPARATOR . "*.doc";
         $aFilePaths = glob($pattern);
         if (empty($aFilePaths)): ?>
                       <img src="/res/wordicondis.png" style="float:left;width:64px">&nbsp;&nbsp;
                      <?PHP else: ?>
                       <a href="/doc?av=<?PHP echo(AVATAR_NAME);?>&re=cv&doc=<?PHP echo(basename($aFilePaths[0]));?>"><img src="/res/wordicon.png" style="float:left;width:64px"></a>&nbsp;&nbsp;
                      <?PHP endif; ?>
                    <?PHP
         $pattern = $CV_PATH . DIRECTORY_SEPARATOR . "*.pdf";
         $aFilePaths = glob($pattern);
         if (empty($aFilePaths)): ?>
                        <img src="/res/pdficondis.png" style="float:left;width:64px">
                        <?PHP else: ?>
                        <a href="/doc?av=<?PHP echo(AVATAR_NAME);?>&re=cv&doc=<?PHP echo(basename($aFilePaths[0]));?>"><img src="/res/pdficon.png" style="float:left;width:64px"></a>
                      <?PHP endif; ?>
            <?PHP endif; ?>
       </div>  
   </div> 
   
  <br>
     
    
 <div id="blog" style="height:fit-content;float:left;margin:6%;margin-top:130px;margin-bottom:5px;width:90%;font-size:15px;font-family:'Press Start 2P';color:#000000;">    
      <?PHP
   $pattern = $BLOG_PATH . DIRECTORY_SEPARATOR . "*.txt";
   $aFilePaths = glob($pattern);
   if (empty($aFilePaths)): ?>
             <div class="blog-content" style="width:100%;float:left;border:3px solid darkgray;border-radius:4px;color:#000000;"> 
              <div class="blog-entry" style="width:100%;margin-bottom:0px;min-height:120px;background:#FFFFFF;border:1px solid black;padding:30px;">  
                Hello from 5 Mode,<br>
                This is just an example of blog entry.
              </div> 
             </div>  
        <?PHP else: ?>
                <?PHP
      $CUDOZ++;          
      $iEntry = 1;          
      foreach ($aFilePaths as $filePath) {
        $s=file_get_contents($filePath); 
        if ($iEntry === count($aFilePaths)) {
          $marginbottom = "0px";
        } else {
          $marginbottom = "5px";
        }
        ?>
                          <div class="blog-content" style="margin-bottom:<?PHP echo($marginbottom);?>;width:100%;float:left;border:3px solid darkgray;border-radius:4px;color:#000000;"> 
                           <div class="blog-entry" style="min-height:120px;background:#FFFFFF;border:1px solid black;padding:30px;">  
                             <?PHP echo(HTMLencode($s, true));?>
                           </div> 
                          </div>   
                 <?PHP 
       $iEntry++;          
      }?>
        <?PHP endif; ?>
   </div> 

 <div id="gallery" style="float:left;margin:6%;margin-top:0px;margin-bottom:5px;width:90%;font-size:15px;font-family:Arial,Sans,Verdana;color:#000000;background:#C2DBF2;">    
   <div class="gallery-content" style="width:100%;float:left;border:3px solid darkgray;border-radius:4px;color:#000000;"> 
     
      <?PHP
   $pattern = $GALLERY_PATH . DIRECTORY_SEPARATOR . "*";
   $aFilePaths = glob($pattern);
   if (empty($aFilePaths)): ?>
             
              <div class="image-entry" style="height:fit-content;min-height:120px;float:left;width:fit-content;border:0px solid green;padding:10px;text-align:center;">  
                  <div style="width:100%;border:0px solid black;"><img src="/res/imgicon.png" align="center" style="width:64px;border:1px solid gray;"></div>
                  <div style="margin-top:10px;">Sample</div>
              </div> 
             
        <?PHP else: ?>
                <?PHP
      $CUDOZ++;          
      $iEntry = 1;          
      foreach ($aFilePaths as $filePath) {
        $orifilename = basename($filePath);
        $filename = explode("|",basename($filePath))[1];
        if ($iEntry === count($aFilePaths)) {
          $marginbottom = "0px";
        } else {
          $marginbottom = "5px";
        }
        ?>
                      <div class="image-entry" style="height:fit-content;min-height:120px;float:left;width:fit-content;border:0px solid green;padding:10px;text-align:center;">  
                        <a href="/img?av=<?PHP echo(AVATAR_NAME);?>&pic=<?PHP echo($orifilename);?>">
                        <div style="width:100%;border:0px solid black;"><img src="/res/imgicon.png" align="center" style="width:64px;border:1px solid gray;"></div>
                        <div style="margin-top:10px;"><?PHP echo($filename);?> </div>
                        </a>  
                      </div> 
                 <?PHP 
       $iEntry++;          
      }?>
        <?PHP endif; ?>
     
      </div>  
   </div> 


 <div id="friends" style="float:left;margin:6%;margin-top:50px;width:90%;font-size:15px;font-family:Arial,Sans,Verdana;color:#000000;background:#dadada">    
   <div class="friends-content" style="width:100%;float:left;border:3px solid transparent;border-radius:4px;color:#000000;padding-top:10px;text-align:center;"> 
     
      <div style="font-family:'Press Start 2P';width:fit-content;margin:auto;color:#245269;">My Network:<br><br>
     
      <?PHP
   $pattern = $FRIENDS_PATH . DIRECTORY_SEPARATOR . "*.txt";
   $aFilePaths = glob($pattern);
   if (empty($aFilePaths)): ?>
             
              <div class="friend-entry" style="height:fit-content;min-height:120px;float:left;width:fit-content;border:0px solid green;padding:10px;text-align:center;">  
                   <a href="http://5mode.com"> 
                   <div style="width:100%;border:0px solid black;"><img src="/res/pic1.png" align="center" style="width:64px;border:0px solid gray;"></div>
                   <div style="margin-top:10px;">Sample</div>
                   </a>
              </div> 
             
        <?PHP else: ?>
                <?PHP
      $CUDOZ++;  
      $iEntry = 1;          
      foreach ($aFilePaths as $filePath) {
        $orifilename = basename($filePath);
        $link=file_get_contents($filePath);
        $filename = pathinfo($filePath, PATHINFO_FILENAME);
        if ($iEntry === count($aFilePaths)) {
          $marginbottom = "0px";
        } else {
          $marginbottom = "5px";
        }
        ?>
                      <div class="friend-entry" style="height:fit-content;min-height:120px;float:left;width:fit-content;border:0px solid green;padding:10px;text-align:center;">  
                        <a href="<?PHP echo($link);?>">
                        <div style="width:100%;border:0px solid black;"><img src="/res/pic1.png" align="center" style="width:64px;border:0px solid gray;"></div>
                        <div style="margin-top:10px;"><?PHP echo($filename);?> </div>
                        </a>  
                      </div> 
                 <?PHP 
       $iEntry++;          
      }?>
        <?PHP endif; ?>
     
          </div>  
          
      </div>  
   </div> 
    
    
  <div id="passworddisplay" style="float:left;position:fixed;top:680px;left:50px;width:255px;height:120px;background:darkgray;text-align:left;white-space:nowrap; font-family:'Bungee Hairline'; color:#d4b0dc; font-weight:900;z-index:99999;">
       <br>  
        &nbsp;&nbsp;<input type="password" id="Password" name="Password" placeholder="password" style="font-size:18px;  background:transparent; width: 60%; border-radius:3px; font-weight:900;" value="<?php echo($password);?>" autocomplete="off">&nbsp;<input type="submit" value="Go" style="text-align:left;width:25%;color:#000000;"><br>
        &nbsp;&nbsp;<input type="text" id="Salt" placeholder="salt" style="position:relative; top:+5px; font-size:18px; background:transparent; width: 90%; border-radius:3px; font-weight:900;" autocomplete="off"><br>
        <div style="text-align:center;">
           <a href="#" onclick="showEncodedPassword();" style="position:relative; left:-2px; top:+5px; font-size:18px; font-weight:900; color:#000000;">Hash Me!</a>
        </div>
 </div> 

 </form>       
     
  <div id="footerCont">&nbsp;</div>
  <div id="footer"><span style="background:#FFFFFF; opacity:0.7;">&nbsp;&nbsp;<a class="aaa" href="dd.html">Disclaimer</a>.&nbsp;&nbsp;A <a href="http://5mode.com" class="aaa">5 Mode</a> project and <a href="http://demo.5mode.com" class="aaa">WYSIWYG</a> system. Some rights reserved.</span></div>
           
 <?PHP endif; ?>           
     
<script src="/js/home-js.php?hl=<?PHP echo($lang);?>&av=<?PHP echo(AVATAR_NAME);?>&cv=<?PHP echo($CURRENT_VIEW);?>&cu=<?PHP echo($CUDOZ);?>" type="text/javascript"></script>

<?php if (file_exists(APP_PATH . DIRECTORY_SEPARATOR . "metrics.html")): ?>
<?php include("../../Public/metrics.html"); ?> 
<?php endif; ?>

</body>
</html>

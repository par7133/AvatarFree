<?PHP
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
 * home-js.php
 * 
 * Avatar Free js for the Home page.
 *
 * @author Daniele Bonini <my25mb@aol.com>
 * @copyrights (c) 2016, 2024, 5 Mode     
 * @license https://opensource.org/licenses/BSD-3-Clause 
 */
 
 require "../../../Private/core/init.inc";

 header("Content-Type: text/javascript");

 // PARAMETERS AND VARIABLES INIT
 
 $lang = APP_DEF_LANG;
 $lang1 = substr(filter_input(INPUT_GET, "hl", FILTER_SANITIZE_STRING), 0, 5);
 if ($lang1 !== PHP_STR) {
   $lang = $lang1;
 }
 
 $AVATAR_NAME=filter_input(INPUT_GET, "av", FILTER_SANITIZE_STRING);
 
 $CURRENT_VIEW=filter_input(INPUT_GET, "cv", FILTER_SANITIZE_STRING);
 
 $CUDOZ=filter_input(INPUT_GET, "cu", FILTER_SANITIZE_STRING);
?>
 

 function showHowTo() {
   alert("Here how to manage your avatars in Avatar Free:\n" +
         "- Type in the url of your avatar like http://" + "<?PHP echo($_SERVER['HTTP_HOST']);?>" + "/<your avatar>.\n" +
         "- Login with your pasword.\n" +
         "- Drag-n-drop in the browser window all the resources you like: \n" +
         "   a. Drop in .txt files to shape your blog.\n" +
         "   b. Drop in pic to shape your gallery; the first one as yr avatar picture.\n" +
         "   c. Drop in texts with link separeted by <ENTER> to shape your friends.\n" +
         "\n" +
         "Enjoy!"); 
 }  

 function startApp() {

   hidePassword();
   
 }			

 function hidePassword() {
   $("#passworddisplay").css("visibility","hidden");
 }  

 /*
  * call to startApp
  * 
  * @returns void
  */
 function _startApp() {
   
   setTimeout("startApp()", 1000);    
 }
 
/*
 *  Display the current hash for the config file
 *  
 *  @returns void
 */
function showEncodedPassword() {
  if ($("#Password").val() === "") {
    $("#Password").addClass("emptyfield");
    return;  
  }
  //if ($("#Salt").val() === "") {
  //  $("#Salt").addClass("emptyfield");
  //  return;  
  //}	   	
  passw = encryptSha2( $("#Password").val() + $("#Salt").val());
  msg = "Please set your hash in the config file with this value:";
  alert(msg + "\n\n" + passw);	
}

function reload() {
  //window.location.reload(); 
  document.getElementById("frmUpload").submit();
}

$("div.dragover").on("dragover", function(e) {
  e.stopPropagation();
  e.preventDefault();

  e.originalEvent.dataTransfer.dropEffect = "copy";

  return false;
});

$("div.dragover").on("drop", function(e) {
  e.stopPropagation();
  e.preventDefault();

  // Get the current Upload form obejct..
  var form = document.getElementById("frmUpload");
  // Create a FormData object including the actual form data..
  var fd = new FormData(form);

  // Get the array of files dropped..
  var dt = e.originalEvent.dataTransfer;
  var files = dt.files;

  var count = files.length;
  //alert("File Count: " + count + "\n");

  if (count !== 0) {

    for (var i = 0; i < count; i++) {
      //alert(" File " + i + ":\n(" + (typeof files[i]) + ") : <" + files[i] + " > " +
      //       files[i].name + " " + files[i].size + " " + files[i].type + "\n");
      fd.append("filesdd[]", files[i]);
    }

    // Submit of the FormData..
    $.ajax("/<?PHP echo($AVATAR_NAME);?>", {
        method: "POST",
        processData: false,
        contentType: false,
        data: fd//,
        //success: function (data) {
        //  $("body").html(data);
        //}
    });
      
    setTimeout("reload()", 2000); 
    
  } else {
    
    mytext = e.originalEvent.dataTransfer.getData('text/plain');
    re = new RegExp(/(https?:\/\/)([\da-z\.-]+)\.([a-z\.]{2,8})(\/?.+)?$/gum);
    matches = mytext.matchAll(re);
    ffriends="";
    if (matches !== null) {
      for(const match of matches) {
        if (ffriends==="") {
          ffriends+=match[0];
        } else {
          ffriends+="|"+match[0];          
        }  
      }
    }
        
    if (ffriends!=="") {
      
      //fd.append("f", ffriends);
      document.getElementById("f").value = ffriends;  
      
      //alert(document.getElementById("f").value);
      
      document.getElementById("frmUpload").submit();
      
    } else {
      alert("ale!");
    }  
  }

  return false;
});

function setContentPos() {                    
  h=parseInt(window.innerHeight);
  w=parseInt(window.innerWidth);

  <?PHP if ($CURRENT_VIEW ==ADMIN_VIEW): ?>
  $("#picavatar").css("top", ((h - 255) / 2) + "px");
  $("#picavatar").css("left", ((w - 255) / 2) + "px");
  $("#picavatar").css("display", "inline");
  <?PHP endif; ?>
  $(".dragover").css("height", h + "px");
  $(".dragover").css("width", w + "px");
  
  mytop = parseInt(window.innerHeight - ($("#passworddisplay").height() + 60));
  $("#passworddisplay").css("top", mytop+"px");
} 

function setFooterPos() {
  if (document.getElementById("footerCont")) {
    tollerance = 16;
    $("#footerCont").css("top", parseInt( window.innerHeight - $("#footerCont").height() - tollerance ) + "px");
    $("#footer").css("top", parseInt( window.innerHeight - $("#footer").height() - tollerance ) + "px");
  }
}

window.addEventListener("load", function() {

  setTimeout("setContentPos()", 500);
  setTimeout("setFooterPos()", 1000);

  // display cudoz
  for (i=1;i<=<?PHP echo($CUDOZ);?>;i++) {
    $("#cudozentry"+i).get(0).src="/res/chicca_it.png";
  }  

  setTimeout("_startApp()", 10000);

}, true);

window.addEventListener("resize", function() {

  setTimeout("setContentPos()", 500);
  setTimeout("setFooterPos()", 1000);

}, true);
  
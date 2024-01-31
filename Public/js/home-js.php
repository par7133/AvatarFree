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
 
 require "../../Private/core/init.inc";

 header("Content-Type: text/javascript");

 // PARAMETERS AND VARIABLES INIT
 
 $lang = APP_DEF_LANG;
 $lang1 = substr(filter_input(INPUT_GET, "hl")??"", 0, 5);
 $lang1 = strip_tags($lang1);
 if ($lang1 !== PHP_STR) {
   $lang = $lang1;
 }
 $shortLang = getShortLang($lang);
 
 $AVATAR_NAME=filter_input(INPUT_GET, "av")??"";
 $AVATAR_NAME = strip_tags($AVATAR_NAME);
 
 $CURRENT_VIEW=filter_input(INPUT_GET, "cv")??"";
 $CURRENT_VIEW = strip_tags($CURRENT_VIEW);
 
 $CUDOZ=filter_input(INPUT_GET, "cu")??"";
 $CUDOZ = strip_tags($CUDOZ);
?>
 
 var myToolsOnIntID;

 function showHowTo() {
 
 <?PHP if ($lang == PHP_EN): ?>
 
   alert("Here how to manage your avatars in Avatar Free:\n" +
         "- Type in the url of your avatar like http://" + "<?PHP echo($_SERVER['HTTP_HOST']);?>" + "/<your avatar>.\n" +
         "- Login with your pasword.\n" +
         "- Drag-n-drop in the browser window all the resources you like: \n" +
         "   a. Drop in .txt files to shape your blog.\n" +
         "   b. Drop in pic to shape your gallery; the first one as yr avatar picture.\n" +
         "   c. Drop in texts with link separeted by <ENTER> to shape your friends.\n" +
         "\n" +
         "Enjoy!"); 
         
  <?PHP elseif ($lang == PHP_IT): ?>       

   alert("Ecco come gestire i tuoi avatar in Avatar Free:\n" +
         "- Scrivi l'url del tuo avatar come http://" + "<?PHP echo($_SERVER['HTTP_HOST']);?>" + "/<tuo avatar>.\n" +
         "- Loggati con la pasword.\n" +
         "- Fai il drag-n-drop nella finestra del browser di tutte le risorse che ritieni: \n" +
         "   a. Trascina file .txt per creare il tuo blog.\n" +
         "   b. Trascina immagini per creare la galleria; la prima sara' il tuo avatar.\n" +
         "   c. Trascina link da testo separati da <INVIO> per creare i tuoi amici.\n" +
         "\n" +
         "Buon proseguimento!"); 
         
  <?PHP elseif ($lang == PHP_CN): ?>              

   alert("在这里如何免费管理您的化身:\n" +
         "- 以以下格式输入阿凡达的URLhttp://" + "<?PHP echo($_SERVER['HTTP_HOST']);?>" + "/<你的头像>.\n" +
         "- 使用密码登录.\n" +
         "- 在浏览器窗口中拖动n-drop您喜欢的所有资源: \n" +
         "   a. 放入.txt文件以形成您的博客.\n" +
         "   b. 放入图片以塑造画廊； 第一个作为您的头像.\n" +
         "   c. 删除带有链接<enter>分隔的链接以塑造您的朋友的文本.\n" +
         "\n" +
         "Enjoy!"); 
         
  <?PHP endif; ?>                
 }  

function settingsOn() {
  $(".settingson").hide();
  $(".magicjar1").show();
  $(".magicjar2").show();
  $(".magicjar3").show();
  $(".settingsoff").show();
  setTimeout("settingsOff()",6000);
}  

function settingsOff() {
  $(".settingsoff").hide("slow");
  $(".magicjar1").hide("slow");
  $(".magicjar2").hide("slow");
  $(".magicjar3").hide("slow");
  $(".settingson").show();
}  

function toolsOn() {
  settingsOn();
  $(".tools").show("slow");
    
  clearInterval(myToolsOnIntID);
}  

function setJar1On() {
  $(".magicjar1").css("background","url(/res/magicjar1.png)");
  $(".magicjar1").css("background-size","120px 120px");
  document.getElementsByClassName("magicjar1")[0].onclick=setJar1Off;
  document.getElementById("txtMagicJar1").value="1";
  document.getElementById("frmUpload").submit();
}

function setJar1Off() {
  $(".magicjar1").css("background","url(/res/magicjar1dis.png)");
  $(".magicjar1").css("background-size","120px 120px");
  document.getElementsByClassName("magicjar1")[0].onclick=setJar1On;
  document.getElementById("txtMagicJar1").value="0"; 
  document.getElementById("frmUpload").submit();
}

function setJar2On() {
  $(".magicjar2").css("background","url(/res/magicjar2.png)");
  $(".magicjar2").css("background-size","120px 120px");
  document.getElementsByClassName("magicjar2")[0].onclick=setJar2Off;
  document.getElementById("txtMagicJar2").value="1"; 
  document.getElementById("frmUpload").submit();
}

function setJar2Off() {
  $(".magicjar2").css("background","url(/res/magicjar2dis.png)");
  $(".magicjar2").css("background-size","120px 120px");
  document.getElementsByClassName("magicjar2")[0].onclick=setJar2On;
  document.getElementById("txtMagicJar2").value="0";
  document.getElementById("frmUpload").submit();
}

function setJar3On() {
  $(".magicjar3").css("background","url(/res/magicjar3.png)");
  $(".magicjar3").css("background-size","120px 120px");
  document.getElementsByClassName("magicjar3")[0].onclick=setJar3Off;
  document.getElementById("txtMagicJar3").value="1";
  document.getElementById("frmUpload").submit();
}

function setJar3Off() {
  $(".magicjar3").css("background","url(/res/magicjar3dis.png)");
  $(".magicjar3").css("background-size","120px 120px");
  document.getElementsByClassName("magicjar3")[0].onclick=setJar3On;
  document.getElementById("txtMagicJar3").value="0";
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
  msg = "<?PHP echo(getResource0("Please set your hash in the config file with this value", $lang, "/js/home-js.php"));?>:";
  alert(msg + "\n\n" + passw);	
}

function changeLang(tthis) {
  window.open("/<?PHP echo($AVATAR_NAME);?>?hl="+$(tthis).val(),"_self");
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
      if (files[i].size > <?PHP echo(APP_FILE_MAX_SIZE); ?>) {
        alert("ERROR: file size (" + files[i].size +") exceeds app limit: <?PHP echo(APP_FILE_MAX_SIZE); ?>");
        return;
      }
      
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
      //alert("ale!");
    }  
  }

  return false;
});

$("input#files").on("change", function(e) {
  frmUpload.submit();
});

function setContentPos() {                    
  h=parseInt(window.innerHeight);
  w=parseInt(window.innerWidth);

  <?PHP if ($CURRENT_VIEW ==ADMIN_VIEW): ?>
  $("#fireupload").css("top", ((h - 255) / 2) + "px");
  $("#fireupload").css("left", ((w - 255) / 2) + "px");
  $("#fireupload").css("display", "inline");
  //$("#picavatar").css("top", ((h - 255) / 2) + "px");
  //$("#picavatar").css("left", ((w - 255) / 2) + "px");
  $("#picavatar").css("display", "inline");
 <?PHP else: ?> 
  if (window.innerWidth<800) {
    $("#cudoz").css("display", "none");
  } else {
    $("#cudoz").css("display", "inline");
  }  
  <?PHP endif; ?>
  $(".dragover").css("height", h + "px");
  $(".dragover").css("width", w + "px");

  newleft=parseInt(window.innerWidth - 145);
  $(".tools").css("left",newleft+"px");
  
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

  <?PHP if ($CURRENT_VIEW ==ADMIN_VIEW): ?>
  myToolsOnIntID = setInterval("toolsOn()", 2000);
 <?PHP else: ?>
  // display cudoz
  for (i=1;i<=<?PHP echo($CUDOZ);?>;i++) {
    $("#cudozentry"+i).get(0).src="/res/chicca_<?PHP echo($shortLang);?>.png";
  }  
 <?PHP endif; ?>
  
  setTimeout("_startApp()", 10000);

}, true);

window.addEventListener("resize", function() {

  setTimeout("setContentPos()", 500);
  setTimeout("setFooterPos()", 1000);

}, true);
  

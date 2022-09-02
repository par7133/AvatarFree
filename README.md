<p align="center">
    <a href="https://avatarfree.org">
        <img src="/Public/res/AFlogo.png" width="188" title="Avatar Free" alt="Avatar Free">
    </a>
</p>

# Avatar Free

Hello and welcome to Avatar Free!<br>
	  
Avatar Free is a light, simple, software on premise to build and own your social presence.<br>
	   
Avatar Free is released under GPLv3 license, it is supplied AS-IS and we do not take any responsibility for its misusage.<br>
	   
First step, use the password box and salt fields to create the hash to insert in the config file. Remember to manually set there also the salt value.<br>
	   
As you are going to run Avatar Free in the PHP process context, using a limited web server or phpfpm user, you must follow some simple directives for an optimal first setup:<br>

<ol>
<li>Check the write permissions of your "data" folder in your web app Private path; and set its path in the config file.</li>
<li>Set the default Locale.</li>
<li>Set IMAGE_MAX_SIZE and DOC_MAX_SIZE (remember that some PHP settings could limit the upload behaviour of Avatar Free too)</li>
</ol> 

You can access your avatar by http://yourdomain.com/<your_avatar>. Login with the password for the admin view. Drag-n-drop all your resources in the browser window.<br>

Hope you can enjoy it and let us know about any feedback: <a href="mailto:info@avatarfree.org" style="color:#e6d236;">info@avatarfree.org</a>

<br>

###Screenshots:

![Avatar Free in action](/Public/res/screenshot1.png)<br>

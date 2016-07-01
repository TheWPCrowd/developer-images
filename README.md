# Developer Images Plugin

What this plugin does is use javascript to re-write all the local URL's for images and media
with another domain.  This is very useful if you want to take a production db, 
copy it to local and still have access to the images on the server. 

It makes it easier to see what your changes will look like when you bring it to 
the server.  

## how to use it

After installing the plug as normal in the plugins directory, you have two choices
of how to configure the setting (there is only one).

* In the Admin screen go to Appearance --> Customize --> Developer Images and change the URL to point to the production server
* In the wp-config.php add a new constant definition for DEV_IMAGES_DESTINATION. 
```
define('DEV_IMAGES_DESTINATION', 'https://www.thewpcrowd.com');
```

## What exactly gets changed

* every img tag SRC that has your local domain in it. 
* every img SRCSET URL that has your local domain in it.
* every source SRC that has your local domain in it (video / audio)
* every occurrence of your local url in an style='' section of a tag (background images)

## So what problems might I find?

This changes every URL, so if the image does not exist on the server, it will look broken. 
This can be a pain if you have left this on when developing a new theme. 

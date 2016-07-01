(function($){
    console.log(devimg);
    
      if (devimg.destination == ''){
          return false;
      }    
      var adapt = {images : document.getElementsByTagName("img"),
                   source : document.getElementsByTagName("source"),
                   alltags : document.getElementsByTagName("body")[0].getElementsByTagName("*")
               };
                      
      
      var regex = new RegExp(devimg.domain,"gi");  
      
      $(adapt.images, adapt.source).each(function(index){
          src = $(this).attr("src");
          if(src != undefined && src.indexOf(devimg.domain) > -1){
             console.log(regex);
             console.log($(this).attr('src'));
             $(this).attr('src', src.replace(regex,devimg.destination));
             console.log($(this).attr('src'));
          }
          
          srcset = $(this).attr('srcset');          
          if(srcset != undefined && srcset.indexOf(devimg.domain) > -1){
              $(this).attr('srcset',  srcset.replace(regex,devimg.destination));
          }
      });
      
      $(adapt.alltags).each(function(index){
          thestyle = $(this).attr("style");
         if(thestyle != undefined && srcset.indexOf(devimg.domain) > -1){             
             $(this).attr("style", thestyle.replace(regex,devimg.destination));
         }
      });
      
})(jQuery);            
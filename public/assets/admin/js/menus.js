$((function(){"use strict";$("#changeLocation").on("change",(function(){var e=$(this).val(),t=$(this).data("base")+"/"+e;location.href=t})),$("#nestmenu").nestable({group:1,maxDepth:$("#nestmenu").data("depth"),callback:function(e,t){var n=(e.length?e:$(e.target)).nestable("toArray");$.ajax({url:$("#nestmenu").data("url"),method:"POST",responseType:"json",data:{menus:n,_token:$("#requesttoken").val()},success:function(e){},error:BuzzyAdmin.return_error})}})}));
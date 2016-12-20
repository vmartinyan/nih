/**
 * Created by me664 on 2/4/15.
 */
jQuery(document).ready(function($){
    var import_debug=$('#import_debug');
   $('.btn_stp_do_import').click(function(){
       var comf = confirm ('Note: Importing data is recommended on fresh installs only once. Importing on sites with content or importing twice will duplicate menus, pages and all posts. Click OK to start !.');
       if(comf == true){
           import_debug.show().html('Importing ... <br><img width="20" height="20" class="loading_import" src="'+svp_importer.loading_src+'">');
           function start_loop_import(url){
               $.ajax({
                   url: url,
                   type: "POST",
                   dataType: "json",
                   success:function(html){
                       if(html){
                           if(html.status == 1){
                               $('.loading_import').remove();
                               import_debug.append('<img width="20" height="20" class="loading_import" src="'+svp_importer.loading_src+'">')
                           }

                           if(html.messenger){

                               import_debug.append(html.messenger);
                           }

                           if(html.next_url != ""){
                               start_loop_import(html.next_url) ;
                           }else{
                               $('.loading_import').remove();
                           }

                           import_debug.scrollTop(import_debug[0].scrollHeight - import_debug.height());
                       }
                   },
                   error:function(html){
                       import_debug.append(html.responseText);
                       import_debug.append('<br><span class="red">Stop Working</span>');
                       import_debug.scrollTop(import_debug[0].scrollHeight - import_debug.height());
                   }
               });
           }
           // start fist
           start_loop_import( $(this).data('url') );
       }
   });
});
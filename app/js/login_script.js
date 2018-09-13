$(document).ready(function(){
    
        $("#form-signin").submit(function(e){
            e.preventDefault();
    
            var login = $.trim($("#login").val());
            var password = $.trim($("#password").val());
    
            if(login == '' || password == '') {
                $("img.profile-img").attr("src", "/data/images/error.png");
            } else {
                $("img.profile-img").attr("src", "/data/images/loading.png");
                $(this).unbind().submit();
            }
        });
    
    });
$(document).ready( function() {
    $("body").on("submit", "#form_login", function(){
        jQuery.ajax({
            url: "/ajax/home.php",
            type: "POST",
            datatype: "JSON",
            success: function(data){
                if (data.state == true)
                {
                    alert("Ca fonctionne");
                }
            }
        })
    });
})
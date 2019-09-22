$(document).ready( function() {
    $("body").on("submit", "#form_login", function(){
        var formData = new FormData(document.getElementById("form_login"))
        jQuery.ajax({
            url: "/ajax/login.php",
            type: "POST",
            data: formData,
            dataType: "JSON",
            cache: false,
			contentType: false, // Ne pas configurer le contentType
			processData: false, // Ne pas traiter les données
            success: function(data){
                if (data.state == true){
                    $(location).attr('href', '/home');
                }
                else{
                    alert("Problème de connexion");
                    console.log(data)
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
				alert("ERREUR", xhr.status + " : " + thrownError, "error");
			}
        })
        return false;
    })
    $("body").on("submit", "#form_signup", function(){
        var formData = new FormData(document.getElementById("form_signup"))
        jQuery.ajax({
            url: "/ajax/signUp.php",
            type: "POST",
            data: formData,
            dataType: "JSON",
            cache: false,
			contentType: false, // Ne pas configurer le contentType
			processData: false, // Ne pas traiter les données
            success: function(data){
                if (data.state == true){
                    $(location).attr('href', '/login');
                }
                else{
                    alert("");
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
				alert("ERREUR", xhr.status + " : " + thrownError, "error");
			}
        })
        return false;
    })
})
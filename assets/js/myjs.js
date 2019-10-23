var errorMessage = function errorMessage(msg){
    Object.keys(msg).forEach(function(key){
        $("#error_"+key).removeClass("d-none")
        $("#error_"+key).text(""+msg[key]+"").css("color", "red")
        $("#error_"+key).prev().addClass("error")
    })
}

$(document).ready( function() {
    $("body").on("click", "input:not(.selected)", function(){
        if($("input").hasClass("error")){
            $("input").removeClass("error")
            $(".form-group p").addClass("d-none")
        }
    })
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
                    $(location).attr('href', '/home')
                }
                else{
                    errorMessage(data.error)
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
				alert("ERREUR", xhr.status + " : " + thrownError, "error")
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
                    $(location).attr('href', '/home')
                }
                else{
                    errorMessage(data.error)
                    let pos_error = $("#"+data.ancre).position().top;
                    $("html").animate({scrollTop : pos_error}, 1000)
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
				alert("ERREUR", xhr.status + " : " + thrownError, "error")
			}
        })
        return false;
    })
    //SIGN UP
    $("#reduce_window_avatar").click(function(){
        $("#table_avatar").toggle("slow")
        if ($(this).text() == "Reduce"){
            $(this).text("Maximize")
        }else{
            $(this).text("Reduce")
        }
    })
    $("#table_avatar").find("td").hover(function(){
        $("#table_avatar tr td").css('cursor', 'default');
        if (!$(this).hasClass("active")){
            if ($(this).hasClass("opacity-05")){
                $(this).removeClass("opacity-05")
            }else{
                $(this).addClass("opacity-05")
            }
            $(this).css('cursor', 'pointer');
        }
    })
    $('body').on('click', '#table_avatar tr td img', function(){
        $('#table_avatar tr td').removeClass("active")
        $('#table_avatar tr td img').removeClass("border-success")
        $('#table_avatar tr td span').not(".opacity-05").addClass("opacity-05")
        $('#table_avatar tr td img').not(".opacity-05").addClass("opacity-05")
        $('#table_avatar tr td img').not(".border-secondary").addClass("border-secondary")

        $(this).next().removeClass("opacity-05")
        $(this).removeClass("opacity-05").removeClass("border-secondary").addClass("border-success")
        $(this).parent().addClass("active").removeClass("opacity-05")

        $("#avatar_signup").attr('value',$(this).data("id"))
        $(this).parent().css('cursor', 'default');
    })
    //HOME
    /*
    $('#home_forum').DataTable({
        "searching": false,
        "paging": false,
        "info": false,
        "autoWidth": false,
        "fnDrawCallback": function (oSettings) {
            $(oSettings.nTHead).hide();
        },
        "columns": [
            { "width": "10%" },
            { "width": "50%" },
            { "width": "10%" },
            { "width": "30%" }
        ]
    });
    */
})
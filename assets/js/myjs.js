var errorMessage = function errorMessage(msg){
    Object.keys(msg).forEach(function(key){
        $("#error_"+key).removeClass("d-none")
        $("#error_"+key).text(""+msg[key]+"").css("color", "red")
        $("#error_"+key).prev().addClass("error")
    })
}

$(document).ready( function() {
    /***
     * 
     * Pagination **
     * */
    const pagination = document.querySelector('.pagination');
    const text = pagination.textContent;
    function goToPage(number = 0) {
        const links = document.querySelectorAll('a');
        links.forEach((link, index) => {
            const letter = link.querySelector('span');
            if (index === number) {
            letter.style.color = 'var(--current)';
            link.className = 'current';
            } else {
            const letterText = letter.textContent;
            letter.style.color = `var(--${letterText}`;
            link.className = '';
            }
        });
    }
    let deb = parseInt($('.pagination').attr("pagination1"))
    let limite = parseInt($('.pagination').attr("pagination2"))
    let cpt = 0
    let diff = limite - deb
    let passage = false
    const html = text
    .split('')
    .map((letter) => {
        if (letter !== 'o') {
            return `<span style="color: var(--${letter.toLowerCase()})">${letter}</span>`;
        }
        cpt += 1;
        if (limite >= 4) {
            if (diff >= 3) {
                if (cpt === 4) {
                    return `<a href="page-${limite}" onclick="goToPage(${limite - 1})"><span style="color: var(--${letter.toLowerCase()})">${letter}</span><span> | ${limite}</span></a>`;
                }
                else {
                    if (cpt === 1 && cpt === deb && passage === false) {
                        passage = true
                        return `<a href="page-${2}" onclick="goToPage(${2})"><span style="color: var(--${letter.toLowerCase()})">${letter}</span><span>${2}</span></a><a href="page-${3}" onclick="goToPage(${3})"><span style="color: var(--${letter.toLowerCase()})">${letter}</span><span>${3}</span></a>`;
                    } else if (cpt === 2 && cpt === deb && passage === false) {
                        passage = true
                        return `<a href="page-${1}" onclick="goToPage(${1})"><span style="color: var(--${letter.toLowerCase()})">${letter}</span><span>${1}</span></a><a><span style="color: var(--${letter.toLowerCase()})">${letter}</span><span>..</span></a><a href="page-${3}" onclick="goToPage(${3})"><span style="color: var(--${letter.toLowerCase()})">${letter}</span><span>${3}</span></a>`;
                    } else if (cpt === 3 && passage === false){
                        return `<a href="page-${deb - 1}" onclick="goToPage(${deb - 1})"><span style="color: var(--${letter.toLowerCase()})">${letter}</span><span>${deb - 1}</span></a><a><span style="color: var(--${letter.toLowerCase()})">${letter}</span><span>..</span></a><a href="page-${deb + 1}" onclick="goToPage(${deb + 1})"><span style="color: var(--${letter.toLowerCase()})">${letter}</span><span>${deb + 1}</span></a>`;
                    }
                }
            }
            else if (diff == 2) {
                if (cpt === 4) {
                    return `<a href="page-${deb - 1}" onclick="goToPage(${deb - 1})"><span style="color: var(--${letter.toLowerCase()})">${letter}</span><span>${deb - 1}</span></a><a><span style="color: var(--${letter.toLowerCase()})">${letter}</span><span>..</span></a><a href="page-${deb + 1}" onclick="goToPage(${deb + 1})"><span style="color: var(--${letter.toLowerCase()})">${letter}</span><span>${deb + 1}</span></a><a href="page-${limite}" onclick="goToPage(${limite - 1})"><span style="color: var(--${letter.toLowerCase()})">${letter}</span><span>${limite}</span></a>`;
                }
            }
            else if (diff == 1) {
                if (cpt === 4) {
                    return `<a href="page-${1}" onclick="goToPage(${1})"><span style="color: var(--${letter.toLowerCase()})">${letter}</span><span>${1} | </span></a><a href="page-${deb - 1}" onclick="goToPage(${deb - 1})"><span style="color: var(--${letter.toLowerCase()})">${letter}</span><span>${deb - 1}</span></a><a><span style="color: var(--${letter.toLowerCase()})">${letter}</span><span>..</span></a><a href="page-${limite}" onclick="goToPage(${limite - 1})"><span style="color: var(--${letter.toLowerCase()})">${letter}</span><span>${limite}</span></a>`;
                }
            }
            else if (diff == 0) {
                if (cpt === 4) {
                    return `<a href="page-${1}" onclick="goToPage(${1})"><span style="color: var(--${letter.toLowerCase()})">${letter}</span><span>${1} | </span></a><a href="page-${deb - 2}" onclick="goToPage(${deb - 2})"><span style="color: var(--${letter.toLowerCase()})">${letter}</span><span>${deb - 2}</span></a><a href="page-${limite - 1}" onclick="goToPage(${limite - 1})"><span style="color: var(--${letter.toLowerCase()})">${letter}</span><span>${limite - 1}</span></a>`;
                }
            }
            else {
                if (passage === false) {
                    passage = true
                    return `<a><span style="color: var(--${letter.toLowerCase()})">${letter}</span><span></span></a>`;
                }
            }
        } else if (limite === 3){
            if (diff == 2) {
                if (cpt === 4) {
                    return `<a href="page-${deb + 1}" onclick="goToPage(${deb + 1})"><span style="color: var(--${letter.toLowerCase()})">${letter}</span><span>${deb + 1}</span></a><a href="page-${limite}" onclick="goToPage(${limite - 1})"><span style="color: var(--${letter.toLowerCase()})">${letter}</span><span>${limite}</span></a>`;
                }
            }
            else if (diff == 1) {
                if (cpt === 4) {
                    return `<a href="page-${deb - 1}" onclick="goToPage(${deb - 1})"><span style="color: var(--${letter.toLowerCase()})">${letter}</span><span>${deb - 1}</span></a><a><span style="color: var(--${letter.toLowerCase()})">${letter}</span><span>..</span></a><a href="page-${limite}" onclick="goToPage(${limite - 1})"><span style="color: var(--${letter.toLowerCase()})">${letter}</span><span>${limite}</span></a>`;
                }
            }
            else if (diff == 0) {
                if (cpt === 4) {
                    return `<a href="page-${1}" onclick="goToPage(${1})"><span style="color: var(--${letter.toLowerCase()})">${letter}</span><span>${1}</span></a><a href="page-${deb - 1}" onclick="goToPage(${deb - 1})"><span style="color: var(--${letter.toLowerCase()})">${letter}</span><span>${deb - 1}</span></a>`;
                }
            }
            else {
                if (passage === false) {
                    passage = true
                    return `<a><span style="color: var(--${letter.toLowerCase()})">${letter}</span><span></span></a>`;
                }
            }
        } else if (limite === 2){
            if (diff == 0) {
                if (cpt === 4) {
                    return `<a href="page-${1}" onclick="goToPage(${1})"><span style="color: var(--${letter.toLowerCase()})">${letter}</span><span>${1}</span></a>`;
                }
            }
            else if (diff == 1) {
                if (cpt === 4) {
                    return `<a href="page-${2}" onclick="goToPage(${2})"><span style="color: var(--${letter.toLowerCase()})">${letter}</span><span>${2}</span></a>`;
                }
            }
            else {
                if (passage === false) {
                    passage = true
                    return `<a><span style="color: var(--${letter.toLowerCase()})">${letter}</span><span></span></a>`;
                }
            }
        } else {
            return `<a><span style="color: var(--${letter.toLowerCase()})">${letter}</span><span></span></a>`;
        }
    })
    .join('');
    pagination.innerHTML = html;

    /**
     * 
     * 
     */
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
})
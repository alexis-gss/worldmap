function getCookie(name) {
    var match = document.cookie.match(RegExp('(?:^|;\\s*)' + name + '=([^;]*)')); 
    return match ? match[1] : null;
}

var btnDarkMode = document.querySelector(".switch__checkBox")

if(getCookie("darkMode") === "true"){
    document.documentElement.style.setProperty('--color1', '#0f1823');
    document.documentElement.style.setProperty('--color2', '#3E3E3E');
    document.documentElement.style.setProperty('--color5', '#FFFFFF');
    btnDarkMode.setAttribute("checked", "true")
}
else if(getCookie("darkMode") === "false"){
    document.cookie = "darkMode=false; expires=Thu, 18 Dec 2100 12:00:00 UTC; path=/";
}

btnDarkMode.addEventListener("click", function(){
    if(btnDarkMode.getAttribute("checked") === null || btnDarkMode.getAttribute("checked") === "false"){
        document.documentElement.style.setProperty('--color1', '#0f1823');
        document.documentElement.style.setProperty('--color2', '#3E3E3E');
        document.documentElement.style.setProperty('--color5', '#FFFFFF');
        btnDarkMode.setAttribute("checked", "true")
        document.cookie = "darkMode=true; expires=Thu, 18 Dec 2100 12:00:00 UTC; path=/";
    }
    else if(btnDarkMode.getAttribute("checked") != null || btnDarkMode.getAttribute("checked") === "true"){
        document.documentElement.style.setProperty('--color1', '#FFFFFF');
        document.documentElement.style.setProperty('--color2', '#E5E5E5');
        document.documentElement.style.setProperty('--color5', '#2E2E2E');
        btnDarkMode.setAttribute("checked", "false")
        document.cookie = "darkMode=false; expires=Thu, 18 Dec 2100 12:00:00 UTC; path=/";
    }
})

window.addEventListener("load", function(event) {
    var loader = document.querySelector(".loader")
    loader.style.opacity = "0"
    setTimeout(function(){
        loader.style.display = "none"
    }, 1000)

    var loginBtn = document.querySelector(".login__btn")
    loginBtn.addEventListener("click", function(){
        loader.style.display = "flex"
        setTimeout(function(){
            loader.style.transition = "1s"
            loader.style.opacity = "1"
        }, 100)
        setTimeout(function(){
            window.location.href = "carte.php"
        }, 1000)
    })

    var parametres = document.querySelector(".parametres")
    var parametresBtnClose = document.querySelector(".parametresBtnClose")
    var parametresContent = document.querySelector(".parametresContent")
    var filtre = document.querySelector(".filtre")
    parametres.addEventListener("click", function(){
        parametresContent.style.transform = "translate(0)"
        filtre.classList.remove("displayNone")
    })
    parametresBtnClose.addEventListener("click", function(){
        parametresContent.style.transform = "translate(-100%)"
        filtre.classList.add("displayNone")
    })
    filtre.addEventListener("click", function(){
        parametresContent.style.transform = "translate(-100%)"
        filtre.classList.add("displayNone")
    })

    setTimeout(function(){
        var paths = document.querySelectorAll(".path")
        for (let i = 0 ; i < paths.length ; i ++) {
            paths[i].style.stroke = "white"   
        }
        anime({
            targets: '.login__titre .lines path',
            strokeDashoffset: [anime.setDashoffset, 0],
            easing: 'easeInOutSine',
            duration: 200,
            delay: function(el, i) { return i * 250 },
        });
    }, 500)

    setTimeout(function(){
        var paths = document.querySelectorAll(".path")
        for (let i = 0 ; i < paths.length ; i ++) {
            paths[i].classList.add("animatedTitle")
        }
    }, 2400)
     
});
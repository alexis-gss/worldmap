<script>
    window.addEventListener("load", function(event) {
        var loader = document.querySelector(".loader")
        loader.style.opacity = "0"
        setTimeout(function() {
            loader.style.display = "none"
        }, 1000)

        var btnExit = document.querySelector(".btnExit")
        btnExit.addEventListener("click", function() {
            loader.style.display = "flex"
            setTimeout(function() {
                loader.style.transition = "1s"
                loader.style.opacity = "1"
            }, 100)
            setTimeout(function() {
                window.location.href = "index.php"
            }, 1000)
        })

        //Création des attributs de la carte
        var mapboxUrl = 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}'
        var mapboxAttribution = 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>'
        var mapboxToken = 'pk.eyJ1IjoiYWxleGlzMDEyMzQ1Njc4OSIsImEiOiJja2FzYWUwbTQwaGx4MzFtc2VraXlnNm9rIn0.433kQBB1jO6KwSlokZbAoA'

        //Caractéristiques des différentes cartes
        var tileStreets = L.tileLayer(mapboxUrl, {
            attribution: mapboxAttribution,
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: mapboxToken
        });
        var tileSatellite = L.tileLayer(mapboxUrl, {
            attribution: mapboxAttribution,
            maxZoom: 18,
            id: 'mapbox/satellite-v9',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: mapboxToken
        });
        var tileSatelliteStreets = L.tileLayer(mapboxUrl, {
            attribution: mapboxAttribution,
            maxZoom: 18,
            id: 'mapbox/satellite-streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: mapboxToken
        });
        var tileLight = L.tileLayer(mapboxUrl, {
            attribution: mapboxAttribution,
            maxZoom: 18,
            id: 'mapbox/light-v10',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: mapboxToken
        });
        var tileDark = L.tileLayer(mapboxUrl, {
            attribution: mapboxAttribution,
            maxZoom: 18,
            id: 'mapbox/dark-v10',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: mapboxToken
        });

        //Attribution de ces cartes dans un menu
        var centre = [46, 2]
        var zoom = 6

        var map = L.map('map', {
            center: centre,
            zoom: zoom,
            layers: [tileLight, tileDark, tileStreets, tileSatellite, tileSatelliteStreets]
        });

        //Attribution des cartes à une description dans ce menu
        var baseMaps = {
            "<?php echo MAP_CLAIR; ?>": tileLight,
            "<?php echo MAP_SOMBRE; ?>": tileDark,
            "<?php echo MAP_RUES; ?>": tileStreets,
            "<?php echo MAP_SATELLITE; ?>": tileSatellite,
            "<?php echo MAP_HYBRIDE; ?>": tileSatelliteStreets
        }

        //Ajout de ce menu à la carte Leaflet
        L.control.layers(baseMaps).addTo(map)

        //Mise en place des différentes variables/tableaux
        var lat = []
        var lng = []
        var markerpopup = []
        var resTab = []
        var pays = []
        var countDestinations = 0
        //Création d'un group de marqueurs
        var markers = [L.markerClusterGroup()]

        //Récupération du fichier .json
        var xmlhttp = new XMLHttpRequest()
        var url = ""

        <?php
        if ($_POST['lang'] == 'fr') {
        ?>
            url = "json/mainFr.json"
        <?php
        } else if ($_POST['lang'] == 'en') {
        ?>
            url = "json/mainEn.json"
        <?php
        }
        ?>

        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var tabJson = JSON.parse(this.responseText)
                myFunction(tabJson)
            }
        };
        xmlhttp.open("GET", url, true)
        xmlhttp.send()

        function myFunction(tab) {
            //Mise en place de certaines variables qui doivent être réinitialisées quand on réappel le fichier .json
            var res = ""
            pays = []
            var j = 0
            var count = 0

            //Parcours le json
            for (let i = 0; i < tab.length; i++) {
                countDestinations = i + 1
                document.querySelector(".installationsTitre").innerHTML = "<?php echo MAP_DESTINATIONS; ?>(" + countDestinations + ")"
                //Création des markers
                if (tab[i].pays === "France") {
                    var marker = L.marker([tab[i].latitude, tab[i].longitude], {
                        icon: L.icon({
                            iconUrl: "data/pictos/marqueur_bleu.png",
                            shadowUrl: '',
                            iconSize: [26, 40], // size of the icon
                            shadowSize: [0, 0], // size of the shadow
                            iconAnchor: [13, 40], // point of the icon which will correspond to marker's location
                            shadowAnchor: [4, 62], // the same for the shadow
                            popupAnchor: [0, -65] // point from which the popup should open relative to the iconAnchor
                        })
                    })
                }
                if (tab[i].pays === "Espagne" || tab[i].pays === "Spain") {
                    var marker = L.marker([tab[i].latitude, tab[i].longitude], {
                        icon: L.icon({
                            iconUrl: "data/pictos/marqueur_orange.png",
                            shadowUrl: '',
                            iconSize: [26, 40], // size of the icon
                            shadowSize: [0, 0], // size of the shadow
                            iconAnchor: [13, 40], // point of the icon which will correspond to marker's location
                            shadowAnchor: [4, 62], // the same for the shadow
                            popupAnchor: [0, -65] // point from which the popup should open relative to the iconAnchor
                        })
                    })
                }
                marker.addEventListener("click", function() {
                    var tables = document.querySelectorAll("table")
                    tableInitial()
                    tables[i].style.backgroundColor = "var(--color2)"
                    setTimeout(function() {
                        if (document.querySelector(".leaflet-popup-close-button") != null) {
                            var leafletPopupCloseButton = document.querySelector(".leaflet-popup-close-button")
                            leafletPopupCloseButton.addEventListener("click", function() {
                                tableInitial()
                            })
                        } else {
                            tableInitial()
                        }
                    }, 300)
                })

                //Affiche TOUTES les installations et leurs caractéristiques
                //Ajout du contrat à un tableau SEULEMENT s'il n'existe pas dans ce même tableau
                for (let p = 0; p < pays.length; p++) {
                    if (pays[p] != tab[i].pays) {
                        count = count + 1
                    }
                }
                if (count === pays.length) {
                    pays.push(tab[i].pays)
                    markers.push(L.markerClusterGroup())
                }
                //Remise à zéro
                count = 0

                if (j === 0) {
                    res += "<table><tbody><tr class='installationsContentGauche'><td>" + tab[i].imgDesc + "</td>" +
                        "<td class='installationsContentDroite'>" + tab[i].annee + "</td></tbody></table>"
                } else {
                    res += "<hr><table><tbody><tr class='installationsContentGauche'><td>" + tab[i].imgDesc + "</td>" +
                        "<td class='installationsContentDroite'>" + tab[i].annee + "</td></tbody></table>"
                }

                //Récupération de toutes les informations concernant les installations
                resTab.push("<center><b><h3>" + tab[i].annee + "</h3><b><hr>" + tab[i].pays + ", " + tab[i].ville + "<br>" +
                    "<br><a href='" + tab[i].lien + "' target='_blank'><img class='popupImg' src='" + tab[i].img + "'></a><br><em>" + tab[i].imgDesc + "</em>")

                //Ajout des latitudes et longitudes dans un tableau
                lat.push(tab[i].latitude)
                lng.push(tab[i].longitude)

                //Évènements lors d'un clique sur un marqueur
                markerpopup.push(marker.bindPopup(resTab[j]))

                //Incrémentation de la variable j
                j = j + 1

                //Ajout des marqueurs au groupement de marqueurs respectif
                for (let m = 0; m < pays.length; m++) {
                    if (tab[i].pays === pays[m]) {
                        markers[m].addLayer(marker)
                    }
                }
            }

            //Ajout du groupement de marqueurs à la carte
            for (let i = 0; i < markers.length; i++) {
                map.addLayer(markers[i]);
            }

            //Ajout des instalations/contrat au menu
            document.getElementById("idTableau").innerHTML = res

            //Modification de la vue lorsqu'un clique sur une installation a lieu
            var test = document.querySelectorAll("table")
            for (let t = 0; t < test.length; t++) {
                test[t].addEventListener("click", function() {
                    var tables = document.querySelectorAll("table")
                    map.setView([lat[t], lng[t]], 12)
                    tableInitial()
                    tables[t].style.backgroundColor = "var(--color2)"
                    markerpopup[t].openPopup()
                    setTimeout(function() {
                        var leafletPopupCloseButton = document.querySelector(".leaflet-popup-close-button")
                        leafletPopupCloseButton.addEventListener("click", function() {
                            tableInitial()
                        })
                    }, 300)
                })
            }
        }

        //Quand on clique sur la flèche pour revenir aux différents contrats
        var flecheRetourContrats = document.querySelector(".installationsRetourContrats")

        function tableInitial() {
            map.addEventListener("click", tableInitial)
            var tables = document.querySelectorAll("table")
            for (let m = 0; m < tables.length; m++) {
                tables[m].style.background = "none"
            }
        }

        //Quand on clique sur le bouton recentrer
        var btnRecentrer = document.querySelector(".btnRecentrer")
        btnRecentrer.addEventListener("click", function() {
            closePopup()
            map.setView(centre, zoom)
            tableInitial()
        })

        //Fermer tous les popups
        function closePopup() {
            map.closePopup()
        }

        //Quand on clique sur le bouton plein écran
        let btnPleinEcran = document.querySelector(".btnPleinEcran")
        let btnSVGon = document.querySelector(".btnSVGon")
        let btnSVGoff = document.querySelector(".btnSVGoff")
        btnPleinEcran.addEventListener("click", function() {
            document.querySelector("body").requestFullscreen()
            btnSVGoff.classList.toggle("displayNone")
            if (btnSVGon.classList.toggle("displayNone") === true) {
                document.exitFullscreen()
            }
        })

        //Quand on clique sur la flèche pour rouler ou dérouler le menu
        let menuContentInstallations = document.querySelector(".menuContentInstallations")
        let btnSVGFleche = document.querySelector(".btnSVGFleche")
        let menu = document.querySelector(".menu")
        let parametres = document.querySelector(".parametres")
        let parametresBtnSVGcross = document.querySelector(".parametresBtnSVGcross")
        let btnSVGparametres = document.querySelector(".btnSVGparametres")
        btnSVGFleche.addEventListener("click", function() {
            if (parametres.classList.contains("displayNone") && parametresBtnSVGcross.classList.contains("displayNone")) {
                if (menu.classList.contains("menuActivated")) {
                    menuContentInstallations.classList.toggle("displayNone")
                    menu.classList.toggle("menuActivated")
                } else {
                    menu.classList.toggle("menuActivated")
                    setTimeout(function() {
                        menuContentInstallations.classList.toggle("displayNone")
                    }, 300)
                }
            } else if (menu.classList.contains("menuActivated")) {
                parametres.classList.toggle("displayNone")
                menu.classList.toggle("menuActivated")
            } else {
                menu.classList.toggle("menuActivated")
                setTimeout(function() {
                    parametres.classList.toggle("displayNone")
                }, 300)
            }
            btnSVGFleche.classList.toggle("flecheActivated")
        })

        btnSVGparametres.addEventListener("click", handler__parametre)
        parametresBtnSVGcross.addEventListener("click", handler__parametre)

        function handler__parametre() {
            if (menu.classList.contains("menuActivated") === false) {
                menuContentInstallations.classList.toggle("displayNone")
                parametres.classList.toggle("displayNone")
                parametresBtnSVGcross.classList.toggle("displayNone")
                btnSVGparametres.classList.toggle("displayNone")
            }
        }

        document.querySelector(".switch__checkBox").addEventListener("click", function() {
            let test = document.querySelector(".switch__checkBox")
            if (test.getAttribute("checked") === null || test.getAttribute("checked") === "false") {
                document.documentElement.style.setProperty('--color1', '#0f1823');
                document.documentElement.style.setProperty('--color2', '#3E3E3E');
                document.documentElement.style.setProperty('--color5', '#FFFFFF');
                test.setAttribute("checked", "true")
                document.cookie = "darkMode=true; expires=Thu, 18 Dec 2100 12:00:00 UTC; path=/";
            } else if (test.getAttribute("checked") != null || test.getAttribute("checked") === "true") {
                document.documentElement.style.setProperty('--color1', '#FFFFFF');
                document.documentElement.style.setProperty('--color2', '#E5E5E5');
                document.documentElement.style.setProperty('--color5', '#2E2E2E');
                test.setAttribute("checked", "false")
                document.cookie = "darkMode=false; expires=Thu, 18 Dec 2100 12:00:00 UTC; path=/";
            }
        })

        //Styliser les mentions Leaflet
        let mentionsParent = document.querySelector(".leaflet-control-container").childNodes
        let mentionsEnfant = mentionsParent[3].childNodes
        mentionsEnfant[0].style.borderRadius = "10px 0 0 0"
        mentionsEnfant[0].style.top = "220px"
        mentionsEnfant[0].style.right = "0"
        mentionsEnfant[0].style.margin = "0"
        mentionsEnfant[0].style.height = "16px"
        mentionsEnfant[0].style.boxShadow = "none"

        document.querySelector(".leaflet-control-zoom-in").title = "<?php echo MAP_TITLE_ZOOM_IN; ?>"
        document.querySelector(".leaflet-control-zoom-in").style.backgroundColor = "var(--color1)"
        document.querySelector(".leaflet-control-zoom-out").title = "<?php echo MAP_TITLE_ZOOM_OUT; ?>"
        document.querySelector(".leaflet-control-zoom-out").style.backgroundColor = "var(--color1)"

        document.querySelector(".leaflet-control-layers-toggle").style.backgroundColor = "var(--color1)"

        <?php
        if (isset($_COOKIE["darkMode"]) && $_COOKIE["darkMode"] === "true") {
        ?>
            document.querySelector(".switch__checkBox").setAttribute("checked", "true")
            document.documentElement.style.setProperty('--color1', '#0f1823');
            document.documentElement.style.setProperty('--color2', '#3E3E3E');
            document.documentElement.style.setProperty('--color5', '#FFFFFF');
        <?php
        }
        ?>
    })
</script>
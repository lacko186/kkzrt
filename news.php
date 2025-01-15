<?php
session_start();
require_once 'config.php';

// Debug információ
error_log("Session tartalma: " . print_r($_SESSION, true));

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['user_id'])) {
    error_log("Nincs bejelentkezve, átirányítás a login.php-ra");
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="hu">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="header.css">
    <script src="betolt.js"></script>
    <title>Kaposbusz</title>
    <style>
     @import url('https://fonts.googleapis.com/css?family=Open+Sans');

    :root {
        --primary-color:linear-gradient(to right, #211717,#b30000);
        --accent-color: #7A7474;
        --text-light: #fbfbfb;
        --secondary-color: #3498db;
        --hover-color: #2980b9;
        --background-light: #f8f9fa;
        --shadow-color: rgba(0, 0, 0, 0.5);
        --transition: all 0.3s ease;
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Open Sans', sans-serif;
        color: #222;
    }

/*--------------------------------------------------------------------------------------------------------CSS - HEADER---------------------------------------------------------------------------------------------------*/
        .header {
            position: relative;
            background: var(--primary-color);
            color: var(--text-light);
            padding: 1rem;
            box-shadow: 0 2px 10px var(--shadow-color);
        }

        .header h1 {
            margin-left: 2%;
            text-align: center;
            font-size: 2rem;
            padding: 1rem 0;
            margin-left: 35%;
            display: inline-block;
        }

        .backBtn{
            display: inline-block;
            width: 3%;
            background: #372E2E;
            border: none;
            box-shadow: 0 2px 10px var(--shadow-color);
        }

        .backBtn:hover{
            background: #b40000;
        }

        .backBtn i{
            height: 30px;
            color: var(--text-light);
            padding-top: 20px;
        }
/*--------------------------------------------------------------------------------------------------------HEADER END-----------------------------------------------------------------------------------------------------*/

    #news-container{
        width:1200px;
        height:400px;
        margin-left:20%;
        margin-top:2%
    }

/*--------------------------------------------------------------------------------------------------------CSS - FOOTER---------------------------------------------------------------------------------------------------*/
footer {
        text-align: center;
        padding: 10px;
        background-color: var(--primary-color);
        color: var(--text-light);
        border-radius: 10px;
        margin-top: 20px;
        box-shadow: var(--shadow);
        background: var(--primary-color);
        color: var(--text-light);
        padding: 3rem 2rem;
        margin-top: 4rem;
    }

    .footer-content {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
    }

    .footer-section h2 {
        margin-bottom: 1rem;
        color: var(--accent-color);
    }

    .footer-links {
        list-style: none;
    }

    .footer-links li {
        margin-bottom: 0.5rem;
    }

    .footer-links a {
        color: var(--text-light);
        text-decoration: none;
        transition: var(--transition);
    }

    .footer-links a:hover {
        color: var(--accent-color);
    }
/*--------------------------------------------------------------------------------------------------------FOOTER END-----------------------------------------------------------------------------------------------------*/


/*--------------------------------------------------------------------------------------------------------CSS - @MEDIA---------------------------------------------------------------------------------------------------*/
        @media (max-width: 480px) {
            .header-content {
                padding: 1rem;
            }

            h1 {
                font-size: 1.5rem;
            }

            .header h1{
                margin-right: 1%;
                margin-left: 1.5%;
                font-size: 1.4rem;
            }

            .backBtn{
                width: 15%;
            }

            #news-container{
                max-width:370px;
                max-height:550px;
                margin-left:10%;
                margin-top:10%
            }

            #details{
                width: 330px;
                font-size: 1.15rem;
            }
            
        }

        @media (max-width: 380px) {
            .header-content {
                padding: 1rem;
            }

            h1 {
                font-size: 1.5rem;
            }
            
            .header h1{
                margin-left: 2%;
            }

            .backBtn{
                width: 15%;
            }

            #news-container{
                max-width:335px;
                max-height:400px;
                margin-left:10%;
                margin-top:10%
            }

            #details{
                width: 310px;
            }
        }
/*--------------------------------------------------------------------------------------------------------@MEDIA END-----------------------------------------------------------------------------------------------------*/
  
    </style>
  </head>
  <body>
<!-- -----------------------------------------------------------------------------------------------------HTML - HEADER------------------------------------------------------------------------------------------------ -->
  <div class="header">
        <button class="backBtn" id=backBtn><img src="back.png" style="width:15px;height:40px;padding-top:12px;padding-bottom:10px;"></button>
        <h1>Kaposvári Közlekedési Zrt. Hírek</h1>
    </div>
<!-- -----------------------------------------------------------------------------------------------------HEADER END--------------------------------------------------------------------------------------------------- -->

<!-- -----------------------------------------------------------------------------------------------------HTML - NEWS CONTAINER---------------------------------------------------------------------------------------- -->
    <div id="news-container"></div>
<!-- -----------------------------------------------------------------------------------------------------NEWS CONTAINER END------------------------------------------------------------------------------------------- -->

<!-- -----------------------------------------------------------------------------------------------------HTML - FOOTER------------------------------------------------------------------------------------------------ -->
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h2>Kaposvár közlekedés</h2>
                <p style="font-style: italic">Megbízható közlekedési szolgáltatások<br> az Ön kényelméért már több mint 50 éve.</p><br>
                <div class="social-links">
                    <a style="color: darkblue;" href="https://www.facebook.com/VOLANBUSZ/"><i class="fab fa-facebook"></i></a>
                    <a style="color: lightblue"href="https://x.com/volanbusz_hu?mx=2"><i class="fab fa-twitter"></i></a>
                    <a style="color: red"href="https://www.instagram.com/volanbusz/"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
           
            <div  class="footer-section">
                <h3>Elérhetőség</h3>
                <ul class="footer-links">
                    <li><i class="fas fa-phone"></i> +36-82/411-850</li>
                    <li><i class="fas fa-envelope"></i> titkarsag@kkzrt.hu</li>
                    <li><i class="fas fa-map-marker-alt"></i> 7400 Kaposvár, Cseri út 16.</li>
                    <li><i class="fas fa-map-marker-alt"></i> Áchim András utca 1.</li>
                </ul>
            </div>
        </div>
        <div style="text-align: center; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.1);">
            <p>© 2024 Kaposvár közlekedési Zrt. Minden jog fenntartva.</p>
        </div>
    </footer>
<!-- -----------------------------------------------------------------------------------------------------FOOTER END--------------------------------------------------------------------------------------------------- -->
    <script>
/*---------------------------------------------------------------------------------------------------------JAVASCRIPT - BACK BUTTON--------------------------------------------------------------------------------------*/
    document.getElementById('backBtn').addEventListener('click', function() {
        window.location.href = 'fooldal.php'; 
    });
/*---------------------------------------------------------------------------------------------------------BACK BUTTON END-----------------------------------------------------------------------------------------------*/

        const news = [
            {
                "img": "/bus.png",
                "title": "Adócsalás",
                "date": "2024.11.23.",
                "details": "Az XY xxx millió Ft-ot csaltak el ezen hétfői napon. Bűneik miatt a következő kedden fognak bíróságra menni."
            },
            {
                "img": "/bus.png",
                "title": "Családi baleset",
                "date": "2024.10.31.",
                "details": "XY család akart el utazni, de balesetbe kerültek. A család 2024. 11. 20-án szálltak fel a KK Zrt. buszára ami nem sokkal később a körforgalomnál felborult. Több felszálló utas megsérült, de szerencsére senki nem halt meg."
            },
            {
                "img": "/bus.png",
                "title": "Menetrend változás",
                "date": "2024.08.11.",
                "details": "Az előző menetrendre sok vevő panaszkodott, így változott a menetrend. A következő hétfőtől a 24-es, 25-ös, 36-os, 37-es mentrendje megváltozik kérjük figyeljenek oda a változásokra."
            },
            {
                "img": "/bus.png",
                "title": "Menetrend ",
                "date": "2024.01.23.",
                "details": "Az előző menetrendre sok vevő panaszkodott"
            },
        ];

        const urlParams = new URLSearchParams(window.location.search);
        const img = urlParams.get('imgPath');
        const title = urlParams.get('title');
        const date = urlParams.get('date');
        const details = urlParams.get('details');

        const newContainer = document.getElementById('news-container');
        newContainer.innerHTML = '';

        // Populate the container with the URL parameter values
        newContainer.innerHTML = `
            <h1 id="title" style="padding-bottom:20px;">${title}</h1>
            <p id="date" style="background: #b30000;width: 90px;border-radius: 3px;padding:3px;color: #fbfbfb;margin-bottom:10px;">${date}</p>
            <p id="details" style="margin-bottom:20px;">${details}</p>
            <img id="img" src="${img}" alt="${title}" style="width: 150px; height: 150px;" />
        `;

        // Append the container to the body or another element in your HTML
        document.div.appendChild(newContainer);

    </script>
  </body>
</html>

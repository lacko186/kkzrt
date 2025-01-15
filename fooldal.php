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
        text-align: center;
        font-size: 2rem;
        padding: 1rem 0;
        margin-left: 38%;
        display: inline-block;
    }

    .nav-wrapper {
        position: absolute;
        top: 1rem;
        left: 1rem;
        z-index: 1000;
    }

    .nav-container {
        position: relative;
    }
/*--------------------------------------------------------------------------------------------------------HEADER END-----------------------------------------------------------------------------------------------------*/

/*--------------------------------------------------------------------------------------------------------CSS - OTHER PARTS----------------------------------------------------------------------------------------------*/
    .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .hero {
        background-image: url('https://kaposvariprogramok.hu/sites/default/files/120845739_825620101509249_2047839847436415923_n.jpg');
        background-repeat: no-repeat;
        background-size: cover;
        background-position: bottom center;
        height: 100vh;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        position: relative;
        margin-bottom: 20px;
        z-index: -2;
    }

    .hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: -1;
    }

    .hero h1 {
        font-size: 46px;
        margin: -20px 0 20px;
    }

    .hero p {
        font-size: 20px;
        letter-spacing: 1px;
    }

    .content h2,
    .content h3 {
        font-size: 150%;
        margin: 20px 0;
    }

    .content p {
        color: #555;
        line-height: 30px;
        letter-spacing: 1.2px;
    }
/*--------------------------------------------------------------------------------------------------------OTHER PARTS END------------------------------------------------------------------------------------------------*/

/*UIverse card */
    .card-container{
        max-width: 1200px; 
        margin-left: 17%;
    }

    .card {
        width: 290px;
        height: 375px;
        border-radius: 20px;
        background: #f5f5f5;
        position: relative;
        padding: 2rem;
        border: 2px solid #c3c6ce;
        transition: 0.5s ease-out;
        overflow: visible;
        margin-left: 8%;
        display: inline-block;
        margin-bottom: 5%;
    }

    .card-details {
        color: black;
        height: 100%;
        gap: .5em;
        display: grid;
        place-content: center;
    }

    .card-button {
        transform: translate(-50%, 125%);
        width: 60%;
        border-radius: 1rem;
        border: none;
        background-color: #b30000;
        color: #fff;
        font-size: 1rem;
        padding: .5rem 1rem;
        position: absolute;
        left: 50%;
        bottom: 0;
        opacity: 0;
        transition: 0.3s ease-out;
    }

    .text-body {
        color: rgb(134, 134, 134);
    }

    /*Text*/
    .text-title {
        font-size: 1.5em;
        font-weight: bold;
    }

    /*Hover*/
    .card:hover {
        border-color:#b30000;
        box-shadow: 0 4px 18px 0 rgba(0, 0, 0, 0.25);
    }

    .card:hover .card-button {
        transform: translate(-50%, 50%);
        opacity: 1;
    }
/*End */

/*--------------------------------------------------------------------------------------------------------CSS - MORE NEWS BUTTON-----------------------------------------------------------------------------------------*/
    .btn-53{
        color: var(--text-light);
        background-color: #b30000;
        border-radius: 30px;
        padding: 15px;
        border: none;
        font-size: 1.5rem;
        margin-left: 42.5%;
        width: 15%;
    }

    .btn-53:hover{
        width: 16%;
        margin-left: 42%;
        background-color:#b60220;
        color:#f5e1e1;
    }
/*--------------------------------------------------------------------------------------------------------MORE NEWS BUTTON END-------------------------------------------------------------------------------------------*/

/*--------------------------------------------------------------------------------------------------------CSS - @MEDIA---------------------------------------------------------------------------------------------------*/
    @media (max-width: 480px) {
            /* Adjust the header */
            .header h1 {
                font-size: 1.5rem;
                margin-left: 12%;
                text-align: center;
            }

            /* Navigation adjustments */
            .nav-wrapper {
                position: static;
                text-align: center;
            }

            /* Hero section */
            .hero {
                height: 50vh;
                background-size: cover;
                padding: 1rem;
                text-align: center;
            }

            .hero h1 {
                font-size: 1.5rem;
            }

            .hero p {
                font-size: 1rem;
            }

            /* Card container and cards */
            .card-container {
                margin-left: 0;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .card {
                width: 90%;
                margin: 1rem 0;
            }

            .card img {
                width: 100px;
                height: 100px;
            }

            .card-button {
                font-size: 0.8rem;
                padding: 0.4rem 1rem;
            }

            .btn-53 {
                width: 60%;
                font-size: 1.3rem;
                padding: 0.5rem;
                margin-left: 20%;
            }

        }
/*--------------------------------------------------------------------------------------------------------@MEDIA END-----------------------------------------------------------------------------------------------------*/
  
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

    </style>
  </head>
  <body>
<!-- -----------------------------------------------------------------------------------------------------HTML - HEADER----------------------------------------------------------------------------------------------- -->
    <div class="header">
        <div class="nav-wrapper">
            <div class="nav-container">
                <button class="menu-btn" id="menuBtn">
                    <div class="hamburger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </button>
                <nav class="dropdown-menu" id="dropdownMenu">
                    <ul class="menu-items">
                        <li>
                            <a href="fooldal.php" class="active">
                                <img src="home.png" alt="Főoldal">
                                <span>Főoldal</span>
                            </a>
                        </li>
                        <li>
                            <a href="index.php" class="active">
                                <img src="placeholder.png" alt="Térkép">
                                <span>Térkép</span>
                            </a>
                        </li>
                        <li>
                            <a href="buy.php">
                                <img src="tickets.png" alt="Jegyvásárlás">
                                <span>Jegyvásárlás</span>
                            </a>
                        </li>
                        <li>
                            <a href="menetrend.php">
                                <img src="calendar.png" alt="Menetrend">
                                <span>Menetrend</span>
                            </a>
                        </li>
                        <li>
                            <a href="jaratok.php">
                            <img src="bus.png" alt="Járatok">
                                <span>&nbsp; Járatok</span>
                            </a>
                        </li>
                        <li>
                            <a href="info.php">
                                <img src="information-button.png" alt="Információ">
                                <span>Információ</span>
                            </a>
                        </li>
                        <li>
                            <a href="logout.php">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Kijelentkezés</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
                <h1>Kaposvár Közlekedési Zrt.</h1>
        </div>
<!-- -----------------------------------------------------------------------------------------------------HEADER END-------------------------------------------------------------------------------------------------- -->

<!-- -----------------------------------------------------------------------------------------------------HTML - HERO-------------------------------------------------------------------------------------------------- -->
    <div class="hero">
      <div class="container">
        <h1>Üdvözöljük a Kaposbusz megújult weboldalán</h1>
      </div>
    </div>
<!-- -----------------------------------------------------------------------------------------------------HERO END----------------------------------------------------------------------------------------------------- -->

<!-- -----------------------------------------------------------------------------------------------------HTML - NEWS-------------------------------------------------------------------------------------------------- -->
    <h1 style="color: #b30000; margin-left: 20%; margin-bottom: 3%; margin-top: 5%;">Hírek</h1>

    <div id="card-container" class="card-container"></div>
<!-- -----------------------------------------------------------------------------------------------------NEWS END----------------------------------------------------------------------------------------------------- -->

<!-- -----------------------------------------------------------------------------------------------------HTML - MORE NEWS BUTTON-------------------------------------------------------------------------------------- -->
    <button class="btn-53" id="btnMoreNews">
        Még több hír >> 
    </button>
<!-- -----------------------------------------------------------------------------------------------------MORE NEWS BUTTON END----------------------------------------------------------------------------------------- -->

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
/*--------------------------------------------------------------------------------------------------------JS - DROPDOWNMENU----------------------------------------------------------------------------------------------*/
        document.getElementById('menuBtn').addEventListener('click', function() {
            this.classList.toggle('active');
            document.getElementById('dropdownMenu').classList.toggle('active');
        });

        // Kívülre kattintás esetén bezárjuk a menüt
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('dropdownMenu');
            const menuBtn = document.getElementById('menuBtn');
            
            if (!menu.contains(event.target) && !menuBtn.contains(event.target)) {
                menu.classList.remove('active');
                menuBtn.classList.remove('active');
            }
        });

        // Aktív oldal jelölése
        document.addEventListener('DOMContentLoaded', function() {
            const currentPage = window.location.pathname.split('/').pop();
            const menuItems = document.querySelectorAll('.menu-items a');
            
            menuItems.forEach(item => {
                if (item.getAttribute('href') === currentPage) {
                    item.classList.add('active');
                }
            });
        });
/*--------------------------------------------------------------------------------------------------------DROPDOWNMENU END-----------------------------------------------------------------------------------------------*/

        const newsData = [
            {
                "img": "bus.png",
                "title": "Év végi közlekedési rend",
                "date": "2024.11.23.",
                "details": "a"
            },
            {
                "img": "bus.png",
                "title": "Családi baleset",
                "date": "2024.10.31.",
                "details": "XY család akart el utazni, de balesetbe kerültek. A család 2024. 11. 20-án szálltak fel a KK Zrt. buszára ami nem sokkal később a körforgalomnál felborult. Több felszálló utas megsérült, de szerencsére senki nem halt meg."
            },
            {
                "img": "bus.png",
                "title": "Menetrend változás",
                "date": "2024.08.11.",
                "details": "Az előző menetrendre sok vevő panaszkodott, így változott a menetrend. A következő hétfőtől a 24-es, 25-ös, 36-os, 37-es mentrendje megváltozik kérjük figyeljenek oda a változásokra."
            },
            {
                "img": "bus.png",
                "title": "Adócsalás",
                "date": "2024.07.03.",
                "details": "Az XY xxx millió Ft-ot csaltak el ezen hétfői napon. Bűneik miatt a következő kedden fognak bíróságra menni."
            },
            {
                "img": "bus.png",
                "title": "Családi baleset",
                "date": "2024.05.28.",
                "details": "XY család akart el utazni, de balesetbe kerültek. A család 2024. 11. 20-án szálltak fel a KK Zrt. buszára ami nem sokkal később a körforgalomnál felborult. Több felszálló utas megsérült, de szerencsére senki nem halt meg."
            },
            {
                "img": "bus.png",
                "title": "Menetrend változás",
                "date": "2024.03.16.",
                "details": "Az előző menetrendre sok vevő panaszkodott, így változott a menetrend. A következő hétfőtől a 24-es, 25-ös, 36-os, 37-es mentrendje megváltozik kérjük figyeljenek oda a változásokra."
            },
            {
                "img": "bus.png",
                "title": "Adócsalás",
                "date": "2024.11.23.",
                "details": "Az XY xxx millió Ft-ot csaltak el ezen hétfői napon. Bűneik miatt a következő kedden fognak bíróságra menni."
            },
            {
                "img": "bus.png",
                "title": "Családi baleset",
                "date": "2024.10.31.",
                "details": "XY család akart el utazni, de balesetbe kerültek. A család 2024. 11. 20-án szálltak fel a KK Zrt. buszára ami nem sokkal később a körforgalomnál felborult. Több felszálló utas megsérült, de szerencsére senki nem halt meg."
            },
        ];

        function truncateText(text, maxLength) {
            if (text.length > maxLength) {
                return text.substring(0, maxLength) + '...';
            }
            return text;
        }

        let showAll = false; // Flag to track whether to show all news

        function displayNews() {
            const container = document.getElementById('card-container');
            container.innerHTML = '';

            const visibleNews = showAll ? newsData : newsData.slice(0, 6); // Display all or only the first 6

            visibleNews.forEach(news => {
                const newsElement = document.createElement('div');
                newsElement.classList.add('card');

                const truncatedDetails = truncateText(news.details, 50);

                newsElement.innerHTML = `
                    <div class="card-details">
                        <p>
                            <img src="${news.img}" style="width: 210px; height: 190px; padding-left: 0.7rem">
                        </p>
                        <p class="text-title" style="font-size:1.3rem;">${news.title}</p>
                        <p class="date" style="background: #b30000;width: 90px;border-radius: 3px;padding:3px;color: #fbfbfb;">${news.date}</p>
                        <p class="text-body">${truncatedDetails}</p>
                    </div>
                    <button class="card-button">More info</button>
                `;

                newsElement.addEventListener('click', () => {
                    const url = new URL('news.php', window.location.origin);
                    url.searchParams.append('imgPath', news.img);
                    url.searchParams.append('title', news.title);
                    url.searchParams.append('date', news.date);
                    url.searchParams.append('details', news.details);
                    window.location.href = url.toString();
                });

                container.appendChild(newsElement);
            });
        }

        function setupButton() {
            const button = document.getElementById('btnMoreNews');
            button.textContent = showAll ? 'Kevesebb hír' : 'Még több hír';

            button.addEventListener('click', () => {
                showAll = !showAll; // Toggle the state
                displayNews(); // Re-render news
                button.textContent = showAll ? 'Kevesebb hír' : 'Még több hír'; // Update button text
            });
        }

        // Initial setup
        displayNews();
        setupButton();
        
    </script>
  </body>
</html>

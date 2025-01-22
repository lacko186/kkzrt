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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kaposvár Intelligens Közlekedés</title>

    <!-- Advanced styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css" rel="stylesheet">

    <link href="footer.css" rel="stylesheet">
    <link href="header.css" rel="stylesheet">
    <!-- Google Maps API -->
    <script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyArXtWdllsylygVw5t_k-22sXUJn-jMU8k&libraries=places&callback=initMap&loading=async">
    </script>

<script>
    window.initMap = function() {
    };
</script>

    <style>
        :root {
            --primary-color:linear-gradient(to right, #211717,#b30000);
            --accent-color: #7A7474;
            --text-light: #fbfbfb;
            --background-light: #f8f9fa;
            --transition: all 0.3s ease;
        }

        body{
            background: #e8e8e8;
        }

/*--------------------------------------------------------------------------------------------------------CSS - HEADER---------------------------------------------------------------------------------------------------*/
    .header {
        position: relative;
        background: var(--primary-color);
        color: var(--text-light);
        padding: 1rem;
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

        /* Custom map and UI enhancements */
        #map {
            height: 650px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }
        .transit-mode-btn {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .transit-mode-btn.active {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }
        #next{
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            font-weight: bolder;
            font-style: italic;
            color: blue;
        }
        button {
            /* Variables */
            --button_radius: 0.75em;
            --button_color: #e8e8e8;
            --button_outline_color: #000000;
            font-size: 17px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            border-radius: var(--button_radius);
            background: var(--button_outline_color);
        }

        .button_top {
            display: block;
            box-sizing: border-box;
            border: 2px solid var(--button_outline_color);
            border-radius: var(--button_radius);
            padding: 0.75em 1.5em;
            background: var(--button_color);
            color: var(--button_outline_color);
            transform: translateY(-0.2em);
            transition: transform 0.1s ease;
        }

        button:hover .button_top {
            /* Pull the button upwards when hovered */
            transform: translateY(-0.33em);
        }

        button:active .button_top {
            /* Push the button downwards when pressed */
            transform: translateY(0);
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
        padding: 3rem 2rem;
        margin-top: 4rem;
    }

    .footer-content {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    }

    .footer-section h2 {
        margin-bottom: 1rem;
        color: var(--text-light);
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

    <div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-2xl rounded-3xl p-8">
    <h1 class="text-4xl font-bold text-center text-red-700 mb-8">
        <i class="fas fa-map-marked-alt mr-3"></i>Kaposvár Mobil Útitárs
    </h1>

    <!-- Advanced Route Planning Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div>
            <label class="block text-gray-700 mb-2">Indulási pont</label>
            <div class="relative">
                <i class="fas fa-map-pin absolute left-4 top-4 text-blue-500"></i>
                <input
                    id="start"
                    type="text"
                    placeholder="pl. Vasútállomás"
                    class="w-full pl-12 pr-4 py-3 border-2 rounded-lg focus:ring-2 focus:ring-blue-500"
                >
            </div>
        </div>
        <div>
            <label class="block text-gray-700 mb-2">Érkezési pont</label>
            <div class="relative">
                <i class="fas fa-flag-checkered absolute left-4 top-4 text-green-500"></i>
                <input
                    id="end"
                    type="text"
                    placeholder="pl. Kossuth tér"
                    class="w-full pl-12 pr-4 py-3 border-2 rounded-lg focus:ring-2 focus:ring-blue-500"
                >
            </div>
        </div>
        <div>
            <label class="block text-gray-700 mb-2">Utazás ideje</label>
            <div class="relative">
                <i class="fas fa-clock absolute left-4 top-4 text-purple-500"></i>
                <input
                    id="travel-time"
                    type="datetime-local"
                    class="w-full pl-12 pr-4 py-3 border-2 rounded-lg focus:ring-2 focus:ring-blue-500"
                >
            </div>
        </div>
    </div>

    <!-- Transit Mode Selection with Advanced Icons -->
    <div class="flex justify-between space-x-4 mb-6">
        <button class="transit-mode-btn flex-1 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition" data-mode="bus">
            <i class="fas fa-bus text-3xl text-blue-600"></i>
            <span class="block mt-2 font-semibold">Helyi Busz</span>
        </button>
        <button class="transit-mode-btn flex-1 p-3 bg-green-50 rounded-lg hover:bg-green-100 transition" data-mode="train">
            <i class="fas fa-train text-3xl text-green-600"></i>
            <span class="block mt-2 font-semibold">Vonat</span>
        </button>
        <button class="transit-mode-btn flex-1 p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition" data-mode="complex">
            <i class="fas fa-network-wired text-3xl text-purple-600"></i>
            <span class="block mt-2 font-semibold">Helyi Járat</span>
        </button>
    </div>

    <!-- Select for Complex Route -->
    <div id="complex-route-select" class="hidden mb-6">
        <label class="block text-gray-700 mb-2">Válasszon induló járatot</label>
        <select id="complex-route" class="w-full p-3 border-2 rounded-lg focus:ring-2 focus:ring-blue-500">
            <option value="">Válasszon</option>
            <option value="12">12 - Helyi autóbusz-állomás - Sopron u. - Laktanya</option>
            <option value="12 vissza">12 vissza - Laktanya - Sopron u. - Helyi autóbusz-állomás</option>
            <option value="13">13 - Helyi autóbusz-állomás - Kecelhegy - Helyi autóbusz-állomás</option>
            <option value="13 vissza">13 vissza - Helyi autóbusz-állomás - Kecelhegy - Helyi autóbusz-állomás</option>
            <option value="20">20 - Raktár u. - Laktanya - Videoton</option>
            <option value="20 vissza">20 vissza - Videoton - Laktanya - Raktár u.</option>
            <option value="21">21 - Raktár u. - Videoton</option>
            <option value="21 vissza">21 vissza - Videoton - Raktár u.</option>
            <option value="23">23 - Kaposfüred forduló - Füredi csp. - Kaposvári Egyetem</option>
            <option value="23 vissza">23 vissza - Kaposvári Egyetem - Füredi csp. - Kaposfüred forduló</option>
            <option value="26">26 - Kaposfüred forduló - Losonc köz - Videoton - METYX</option>
            <option value="26 vissza">26 vissza - METYX - Videoton - Losonc köz - Kaposfüred forduló</option>
            <option value="27">27 - Laktanya - Füredi u. csp. - KOMÉTA</option>
            <option value="27 vissza">27 vissza - KOMÉTA - Füredi u. csp. - Laktanya</option>
            <option value="31">31 - Helyi autóbusz-állomás - Egyenesi u. forduló</option>
            <option value="31 vissza">31 vissza - Egyenesi u. forduló - Helyi autóbusz-állomás</option>
            <option value="32">32 - Helyi autóbuszállomás - Kecelhegy - Helyi autóbusz-állomás</option>
            <option value="32 vissza">32 vissza - Helyi autóbusz-állomás - Kecelhegy - Helyi autóbuszállomás</option>
            <option value="33">33 - Helyi aut. áll. - Egyenesi u. - Kecelhegy - Helyi aut. áll.</option>
            <option value="33 vissza">33 vissza - Helyi aut. áll. - Kecelhegy - Egyenesi u. - Helyi aut. áll.</option>
            <option value="40">40 - Koppány vezér u - 67-es út - Raktár u.</option>
            <option value="40 vissza">40 vissza - Raktár u. - 67-es út - Koppány vezér u</option>
            <option value="41">41 - Koppány vezér u - Bartók B. u. - Raktár u.</option>
            <option value="41 vissza">41 vissza - Raktár u. - Bartók B. u. - Koppány vezér u</option>
            <option value="42">42 - Töröcske forduló - Kórház - Laktanya</option>
            <option value="42 vissza">42 vissza - Laktanya - Kórház - Töröcske forduló</option>
            <option value="43">43 - Helyi autóbusz-állomás - Kórház- Laktanya - Raktár utca - Helyi autóbusz-állomás</option>
            <option value="43 vissza">43 vissza - Helyi autóbusz-állomás - Raktár utca - Laktanya - Kórház - Helyi autóbusz-állomás</option>
            <option value="44">44 - Helyi autóbusz-állomás - Raktár utca - Laktanya -Arany János tér - Helyi autóbusz-állomás</option>
            <option value="44 vissza">44 vissza - Helyi autóbusz-állomás - Arany János tér - Laktanya - Raktár utca - Helyi autóbusz-állomás</option>
            <option value="45">45 - Helyi autóbusz-állomás - 67-es út - Koppány vezér u.</option>
            <option value="45 vissza">45 vissza - Koppány vezér u. - 67-es út - Helyi autóbusz-állomás</option>
            <option value="46">46 - Helyi autóbusz-állomás - Töröcske forduló</option>
            <option value="46 vissza">46 vissza - Töröcske forduló - Helyi autóbusz-állomás</option>
            <option value="47">47 - Koppány vezér u.- Kórház - Kaposfüred forduló</option>
            <option value="47 vissza">47 vissza - Kaposfüred forduló - Kórház - Koppány vezér u.</option>
            <option value="61">61 - Helyi- autóbuszállomás - Béla király u.</option>
            <option value="61 vissza">61 vissza - Béla király u. - Helyi autóbusz-állomás</option>
            <option value="62">62 - Helyi autóbusz-állomás - Városi fürdő - Béla király u.</option>
            <option value="62 vissza">62 vissza - Béla király u. - Városi fürdő - Helyi autóbusz-állomás</option>
            <option value="70">70 - Helyi autóbusz-állomás - Kaposfüred</option>
            <option value="70 vissza">70 vissza - Kaposfüred - Helyi autóbusz-állomás</option>
            <option value="71">71 - Kaposfüred forduló - Kaposszentjakab forduló</option>
            <option value="71 vissza">71 vissza - Kaposszentjakab forduló - Kaposfüred forduló</option>
            <option value="72">72 - Kaposfüred forduló - Hold u. - Kaposszentjakab forduló</option>
            <option value="72 vissza">72 vissza - Kaposszentjakab forduló - Hold u. - Kaposfüred forduló</option>
            <option value="73">73 - Kaposfüred forduló - KOMÉTA - Kaposszentjakab forduló</option>
            <option value="73 vissza">73 vissza - Kaposszentjakab forduló - KOMÉTA - Kaposfüred forduló</option>
            <option value="74">74 - Hold utca - Helyi autóbusz-állomás</option>
            <option value="74 vissza">74 vissza - Helyi autóbusz-állomás - Hold utca</option>
            <option value="75">75 - Helyi autóbusz-állomás - Kaposszentjakab</option>
            <option value="75 vissza">75 vissza - Kaposszentjakab - Helyi autóbusz-állomás</option>
            <option value="81">81 - Helyi autóbusz-állomás - Hősök temploma - Toponár forduló</option>
            <option value="81 vissza">81 vissza - Toponár forduló - Hősök temploma - Helyi autóbusz-állomás</option>
            <option value="82">82 - Helyi autóbusz-állomás - Kórház - Toponár Szabó P. u.</option>
            <option value="82 vissza">82 vissza - Toponár Szabó P. u. - Kórház - Helyi autóbusz-állomás</option>
            <option value="83">83 - Helyi autóbusz-állomás - Szabó P. u. - Toponár forduló</option>
            <option value="83 vissza">83 vissza - Toponár forduló - Szabó P. u. - Helyi autóbusz-állomás</option>
            <option value="84">84 - Helyi autóbusz-állomás - Toponár, forduló - Répáspuszta</option>
            <option value="84 vissza">84 vissza - Répáspuszta - Toponár, forduló - Helyi autóbusz-állomás</option>
            <option value="85">85 - Helyi autóbusz-állomás - Kisgát- Helyi autóbusz-állomás</option>
            <option value="85 vissza">85 vissza - Helyi autóbusz-állomás - Kisgát- Helyi autóbusz-állomás</option>
            <option value="86">86 - Helyi autóbusz-állomás - METYX - Szennyvíztelep</option>
            <option value="86 vissza">86 vissza - Szennyvíztelep - METYX - Helyi autóbusz-állomás</option>
            <option value="87">87 - Helyi autóbusz állomás - Videoton - METYX</option>
            <option value="87 vissza">87 vissza - METYX - Videoton - Helyi autóbusz állomás</option>
            <option value="88">88 - Helyi autóbusz-állomás - Videoton</option>
            <option value="88 vissza">88 vissza - Videoton - Helyi autóbusz-állomás</option>
            <option value="89">89 - Helyi autóbusz-állomás - Kaposvári Egyetem</option>
            <option value="89 vissza">89 vissza - Kaposvári Egyetem - Helyi autóbusz-állomás</option>
            <option value="90">90 - Helyi autóbusz-állomás - Rómahegy</option>
            <option value="90 vissza">90 vissza - Rómahegy - Helyi autóbusz-állomás</option>
            <option value="91">91 - Rómahegy - Pázmány P u. - Füredi u. csp</option>
            <option value="91 vissza">91 vissza - Rómahegy - Pázmány P u. - Füredi u. csp</option>
        </select>
    </div>

    <!-- Advanced Route Search Button -->
    <button id="find-route" class="w-full bg-red-700 text-white py-4 rounded-lg hover:bg-black transition mb-6 flex items-center justify-center">
        <i class="fas fa-route mr-3"></i>Útvonal keresése
    </button>

    <!-- Map and Route Details Container -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2">
            <div id="map" class="w-full rounded-2xl"></div>
        </div>

        <!-- Detailed Route Information Panel -->
        <div id="route-details" class="bg-gray-50 p-6 rounded-2xl">
            <h3 class="text-2xl font-semibold mb-4 text-gray-800 flex items-center">
                <i class="fas fa-info-circle mr-3 text-red-700"></i>Útvonal Részletek
            </h3>
            <div id="route-info" class="space-y-4">
                <!-- Dynamic route information will be inserted here -->
            </div>
        </div>          
        <a href="map_2.php"><button>
        <span style="font-weight:bold" class="button_top">Megálló keresése ➤</span>
        </button>
        </a>
    </div>
</div>

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

        // Global variables
        let map;
        let directionsService;
        let directionsRenderer;
        let markers = [];

        // Kaposvár központi koordinátái
        const KAPOSVAR_CENTER = {
            lat: 46.3593,
            lng: 17.7967
        };

        // Map initialization
        function initMap() {
            // Initialize the map
            map = new google.maps.Map(document.getElementById('map'), {
                center: KAPOSVAR_CENTER,
                zoom: 13,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            // Initialize directions services
            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer({
                map: map,
                panel: document.getElementById('route-info')
            });

            // Initialize autocomplete for input fields
            setupAutocomplete();
            
            // Setup event listeners
            setupEventListeners();
        }

        function setupAutocomplete() {
            const options = {
                componentRestrictions: { country: 'hu' },
                bounds: new google.maps.LatLngBounds(
                    new google.maps.LatLng(46.2093, 17.6467),
                    new google.maps.LatLng(46.5093, 17.9467)
                ),
                strictBounds: false
                // types megszorítás nélkül minden helyet megtalál
            };

            const startInput = document.getElementById('start');
            const endInput = document.getElementById('end');
            
            if (startInput && endInput) {
                new google.maps.places.Autocomplete(startInput, options);
                new google.maps.places.Autocomplete(endInput, options);
            }
        }
        // Setup event listeners
        function setupEventListeners() {
            // Route search button
            document.getElementById('find-route').addEventListener('click', calculateRoute);

            // Transit mode buttons
            document.querySelectorAll('.transit-mode-btn').forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    document.querySelectorAll('.transit-mode-btn').forEach(btn => 
                        btn.classList.remove('active')
                    );
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    // Show/hide complex route select if needed
                    const complexSelect = document.getElementById('complex-route-select');
                    if (this.dataset.mode === 'complex') {
                        complexSelect.classList.remove('hidden');
                    } else {
                        complexSelect.classList.add('hidden');
                    }
                });
            });
        }

        // Calculate and display route
        function calculateRoute() {
            const start = document.getElementById('start').value;
            const end = document.getElementById('end').value;
            const travelTime = document.getElementById('travel-time').value;
            const activeMode = document.querySelector('.transit-mode-btn.active')?.dataset.mode;

            // Validate inputs
            if (!start || !end) {
                alert('Kérem adja meg az indulási és érkezési pontot!');
                return;
            }

            // Determine travel mode
            let travelMode;
            let transitOptions = {};

            switch (activeMode) {
                case 'train':
                    travelMode = google.maps.TravelMode.TRANSIT;
                    transitOptions = {
                        modes: ['TRAIN'],
                        routingPreference: 'FEWER_TRANSFERS'
                    };
                    break;
                case 'bus':
                    travelMode = google.maps.TravelMode.TRANSIT;
                    transitOptions = {
                        modes: ['BUS'],
                        routingPreference: 'FEWER_TRANSFERS'
                    };
                    break;
                case 'complex':
                    travelMode = google.maps.TravelMode.TRANSIT;
                    transitOptions = {
                        modes: ['BUS', 'TRAIN'],
                        routingPreference: 'FEWER_TRANSFERS'
                    };
                    break;
                default:
                    travelMode = google.maps.TravelMode.DRIVING;
            }

            // Setup route request
            const request = {
                origin: start,
                destination: end,
                travelMode: travelMode,
                transitOptions: travelTime ? {
                    ...transitOptions,
                    departureTime: new Date(travelTime)
                } : transitOptions
            };

            // Calculate route
            directionsService.route(request, (result, status) => {
                if (status === google.maps.DirectionsStatus.OK) {
                    directionsRenderer.setDirections(result);
                    displayRouteDetails(result);
                } else {
                    alert('Útvonaltervezés sikertelen: ' + status);
                }
            });
        }

        // Display route details
        function displayRouteDetails(result) {
            const route = result.routes[0];
            const routeInfo = document.getElementById('route-info');
            
            if (!route || !route.legs || !route.legs[0]) {
                routeInfo.innerHTML = '<p>Nem található útvonal információ</p>';
                return;
            }

            const leg = route.legs[0];
            
            let html = `
                <div class="bg-white p-4 rounded-lg shadow">
                    <p class="font-bold text-lg mb-2">Teljes távolság: ${leg.distance.text}</p>
                    <p class="font-bold text-lg mb-4">Becsült idő: ${leg.duration.text}</p>
                    <div class="space-y-2">
                        <p><strong>Indulás:</strong> ${leg.start_address}</p>
                        <p><strong>Érkezés:</strong> ${leg.end_address}</p>
                    </div>`;

            // Add transit details if available
            if (leg.steps) {
                html += '<div class="mt-4"><strong>Útvonal részletei:</strong><ul class="mt-2 space-y-2">';
                leg.steps.forEach(step => {
                    let instruction = step.instructions;
                    if (step.transit) {
                        instruction = `${step.transit.line.vehicle.name || 'Járat'} - ${step.transit.line.name || step.transit.line.short_name}`;
                    }
                    html += `<li>${instruction}</li>`;
                });
                html += '</ul></div>';
            }

            html += '</div>';
            routeInfo.innerHTML = html;
        }

        // Add markers for local transit stops
        function addTransitStops() {
            // Clear existing markers
            markers.forEach(marker => marker.setMap(null));
            markers = [];

            // Example transit stops - replace with your actual data
            const stops = [
                { position: { lat: 46.3593, lng: 17.7967 }, title: "Kaposvár Központ" },
                { position: { lat: 46.3600, lng: 17.7900 }, title: "Vasútállomás" },
                // Add more stops as needed
            ];
            stops.forEach(stop => {
                const marker = new google.maps.Marker({
                    position: stop.position,
                    map: map,
                    title: stop.title,
                    icon: {
                        url: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'
                    }
                });
                markers.push(marker);
            });
        }
        function calculateRoute() {
            const start = document.getElementById('start').value;
            const end = document.getElementById('end').value;
            const travelTime = document.getElementById('travel-time').value;
            const activeMode = document.querySelector('.transit-mode-btn.active')?.dataset.mode;

            if (!start || !end) {
                alert('Kérem adja meg az indulási és érkezési pontot!');
                return;
            }

            // Alap request objektum
            const request = {
                origin: start,
                destination: end,
                travelMode: google.maps.TravelMode.DRIVING, // Alapértelmezett
                region: 'hu',                               // Magyar régió
                language: 'hu',                             // Magyar nyelv
                optimizeWaypoints: true,                    // Útvonal optimalizálás
                provideRouteAlternatives: true              // Alternatív útvonalak kérése
            };

            // Közlekedési mód és opciók beállítása
            if (activeMode) {
                const departureTime = travelTime ? new Date(travelTime) : new Date();
                
                switch (activeMode) {
                    case 'train':
                        request.travelMode = google.maps.TravelMode.TRANSIT;
                        request.transitOptions = {
                            modes: ['TRAIN', 'RAIL'],
                            routingPreference: 'FEWER_TRANSFERS',
                            departureTime: departureTime
                        };
                        break;
                    case 'bus':
                        request.travelMode = google.maps.TravelMode.TRANSIT;
                        request.transitOptions = {
                            modes: ['BUS'],
                            routingPreference: 'FEWER_TRANSFERS',
                            departureTime: departureTime
                        };
                        break;
                    case 'complex':
                        request.travelMode = google.maps.TravelMode.TRANSIT;
                        request.transitOptions = {
                            modes: ['BUS', 'TRAIN', 'RAIL'],
                            routingPreference: 'FEWER_TRANSFERS',
                            departureTime: departureTime
                        };
                        break;
                }
            }

            // Útvonal keresése
            directionsService.route(request, async (result, status) => {
                if (status === google.maps.DirectionsStatus.OK) {
                    directionsRenderer.setDirections(result);
                    displayRouteDetails(result);
                    
                    // Jármű követés indítása
                    if (result.routes[0]?.legs[0]?.steps?.some(step => step.travel_mode === 'TRANSIT')) {
                        const mode = activeMode === 'train' ? 'train' : 'bus';
                        await initializeVehicleTracking(result, mode);
                    }
                } else if (status === google.maps.DirectionsStatus.ZERO_RESULTS) {
                    // Ha nem található tömegközlekedési útvonal, próbáljuk meg alternatív módon
                    handleNoTransitRoute(start, end, activeMode);
                } else {
                    handleRoutingError(status);
                }
            });
        }

        // Alternatív útvonal keresése ha nincs tömegközlekedés
        async function handleNoTransitRoute(start, end, activeMode) {
            try {
                // Próbáljuk meg először driving móddal
                const drivingRequest = {
                    origin: start,
                    destination: end,
                    travelMode: google.maps.TravelMode.DRIVING,
                    region: 'hu',
                    language: 'hu'
                };

                directionsService.route(drivingRequest, (result, status) => {
                    if (status === google.maps.DirectionsStatus.OK) {
                        directionsRenderer.setDirections(result);
                        
                        // Alternatív útvonal információ megjelenítése
                        const routeInfo = document.getElementById('route-info');
                        routeInfo.innerHTML = `
                            <div class="bg-white p-4 rounded-lg shadow">
                                <div class="text-yellow-600 mb-4">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                    <span>Tömegközlekedési útvonal nem található. Alternatív útvonal megjelenítése.</span>
                                </div>
                                ${routeInfo.innerHTML}
                            </div>
                        `;
                    } else {
                        handleRoutingError(status);
                    }
                });
            } catch (error) {
                console.error('Hiba az alternatív útvonal keresésekor:', error);
                handleRoutingError('UNKNOWN_ERROR');
            }
        }

        // Útvonaltervezési hibák kezelése
        function handleRoutingError(status) {
            let errorMessage = 'Ismeretlen hiba történt az útvonaltervezés során.';
            
            switch (status) {
                case 'ZERO_RESULTS':
                    errorMessage = 'Nem található útvonal a megadott pontok között.';
                    break;
                case 'NOT_FOUND':
                    errorMessage = 'A megadott címek egyike vagy mindegyike nem található.';
                    break;
                case 'OVER_QUERY_LIMIT':
                    errorMessage = 'Az útvonaltervezési kérések száma túllépte a limitet. Kérjük próbálja később.';
                    break;
                case 'REQUEST_DENIED':
                    errorMessage = 'Az útvonaltervezési kérés elutasítva. Ellenőrizze az API kulcsot.';
                    break;
                case 'INVALID_REQUEST':
                    errorMessage = 'Érvénytelen útvonaltervezési kérés.';
                    break;
            }

            // Hibaüzenet megjelenítése a felhasználói felületen
            const routeInfo = document.getElementById('route-info');
            routeInfo.innerHTML = `
                <div class="bg-white p-4 rounded-lg shadow">
                    <div class="text-red-600">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span>${errorMessage}</span>
                    </div>
                    <div class="mt-4 text-gray-600">
                        Javasoljuk:
                        <ul class="list-disc ml-6 mt-2">
                            <li>Ellenőrizze a megadott címeket</li>
                            <li>Próbáljon meg közelebbi célpontot választani</li>
                            <li>Próbáljon meg másik közlekedési módot választani</li>
                        </ul>
                    </div>
                </div>
            `;

            console.error('Útvonaltervezési hiba:', status);
        }
</script>
</body>
</htm>

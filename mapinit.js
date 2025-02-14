
/*--------------------------------------------------------------------------------------------------------JAVASCRIPT - SWITCH BUTTON LOGIC-------------------------------------------------------------------------------*/
        //switch button logic
        document.getElementById("switchBtn").onclick = function() {
            const startInput = document.getElementById("start");

          
        };
/*--------------------------------------------------------------------------------------------------------SWITCH BUTTON LOGIC END----------------------------------------------------------------------------------------*/

/*--------------------------------------------------------------------------------------------------------JAVASCRIPT - NAV BAR SCRIPT------------------------------------------------------------------------------------*/

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
/*--------------------------------------------------------------------------------------------------------NAV BAR SCRIPT END---------------------------------------------------------------------------------------------*/
    
        let map, directionsService, directionsRenderer;
                const kaposvarBusStops = [
                    {name: "Kaposvár,helyi autóbusz állomás", lat: 46.353712944816756 , lng: 17.790623009204865},             
                    {name: "Kaposvár,Berzsenyi utca felűljáró", lat: 46.356517550424560 , lng: 17.785293459892273},        
                    {name: "Kaposvár,Berzsenyi utca. 30.",  lat: 46.360245694362280 , lng: 17.783764600753784},                                            
                    {name: "Kaposvár,Ballakúti u.", lat: 46.341454000000000 , lng: 17.800144000000000},                                                                                                                   
                    {name: "Kaposvár,Lonkahegy forduló", lat: 46.341060000000000 , lng: 17.809980000000000},                                                           
                    {name: "Kaposvár,Nyár .", lat: 46.340230000000000 , lng:   17.806737000000000     },                               
                    {name: "Kaposvár,Berzsenyi u. felűljáró   ", lat: 46.355407000000000 , lng: 17.784772000000000},                                                 
                    {name: "Kaposvár,Jókai liget", lat: 46.351217000000000 , lng:   17.791028000000000},         
                    {name: "Kaposvár,Szigetvári u. 6. ", lat: 46.349016000000000 , lng:    17.794155000000000},                                                                             
                    {name: "Kaposvár,Szigetvári u. 62.   ", lat: 46.345504000000000 , lng: 17.796827000000000},                                                                                     
                    {name: "Kaposvár,Szigetvári u. 139.", lat: 46.339967000000000 , lng:    17.801641000000000    } ,                                                                                          
                    {name: "Kaposvár,Kaposfüred vá.", lat: 46.414177188967860 , lng:    17.759399414062500    } ,                                                                                      
                    {name: "Kaposvár,Bersenyi u. 30. ", lat: 46.360245694362280 , lng:    17.783764600753784    } ,                                                                                           
                    {name: "Kaposvár,Füredi u. csp.", lat: 46.364636210963700 , lng:    17.782359123229980    } ,                                                                                      
                    {name: "Kaposvár,Toldi lakónegyed", lat: 46.367282937091694 , lng:    17.782611250877380    } ,                                                                                          
                    {name: "Kaposvár,Kinizsi ltp.", lat: 46.371837596984186 , lng:    17.782562971115112    } ,                                                                                            
                    {name: "Kaposvár,Búzavirág u.", lat: 46.376005120381800 , lng:    17.781790494918823    } ,                                                                                                
                    {name: "Kaposvár,Laktanya", lat: 46.378899252341710 , lng:    17.781264781951904    } ,                                                                                           
                    {name: "Kaposvár,Volán-telep", lat: 46.390476096295025 , lng:    17.779242396354675    } ,                                                                                     
                    {name: "Kaposvár,Kaposfüredi u. 12.", lat: 46.402831025305830 , lng:    17.779363095760345    } ,                                                                                   
                    {name: "Kaposvár,Kaposfüredi u. 104.", lat: 46.408939937748370 , lng:    17.779510617256165    } ,                                        
                    {name: "Kaposvár,Kaposfüred központ", lat: 46.413452288702540 , lng:    17.777397036552430    } ,                                                
                    {name: "Kaposvár,Állomás u.", lat: 46.413161956046970 , lng:    17.762910425662994    } ,                        
                    {name: "Kaposvár,Kaposfüredi u. 244.", lat: 46.419606237670900 , lng:    17.776479721069336    } ,                         
                    {name: "Kaposvár,Kaposfüred forduló", lat: 46.422991722931310 , lng:    17.775487303733826    } ,                            
                    {name: "Kaposvár,Városi könyvtár", lat: 46.363116599065280 , lng:    17.776970565319060    } ,                                                            
                    {name: "Kaposvár,Vasútköz", lat: 46.363973583932410 , lng: 17.770326733589172       } ,                     
                    {name: "Kaposvár,Raktár u. forduló", lat: 46.379363705526960 , lng:    17.769232392311096    } ,                                                
                    {name: "Kaposvár,Mátyás k. u. forduló", lat: 46.366068790536570 , lng:    17.758959531784058    } ,                       
                    {name: "Kaposvár,Egyenesi u. forduló", lat: 46.339085936499174 , lng:    17.763682901859283    } ,                    
                    {name: "Kaposvár,Koppány vezér u. forduló", lat: 46.345209389542640 , lng:    17.771404981613160    } ,                            
                    {name: "Kaposvár,Töröcske forduló", lat: 46.313599675140970 , lng:    17.779864668846130    } ,                      
                    {name: "Kaposvár,Béla király u. forduló", lat: 46.348434712544030 , lng:    17.815065979957580    } ,                     
                    {name: "Kaposvár,Kaposszentjakab forduló", lat: 46.359686674094590 , lng:    17.847394645214080    } ,                             
                    {name: "Kaposvár,Toponár forduló", lat: 46.407843232130425 , lng:    17.836671173572540    } ,                                
                    {name: "Kaposvár,NABI forduló", lat: 46.365024899057650 , lng:    17.848915457725525    } ,                           
                    {name: "Kaposvár,Kaposvári Egyetem", lat: 46.383808193175200 , lng:    17.825261056423187    } ,                                    
                    {name: "Kaposvár,Videoton", lat: 46.364040217181720 , lng:    17.820736169815063    } ,                                  
                    {name: "Kaposvár,Buzsáki u.", lat: 46.367928866868034 , lng:    17.792299389839172    } ,                                    
                    {name: "Kaposvár,Aranytér", lat: 46.367667904754760 , lng:    17.790201902389526    } ,                          
                    {name: "Kaposvár,Sopron u. forduló ", lat: 46.375490674220465 , lng:    17.785727977752686    } ,                               
                    {name: "Kaposvár,Tóth Árpád u.", lat: 46.371870908822820 , lng:    17.767518460750580    } ,             
                    {name: "Kaposvár,Kométa forduló", lat: 46.356947021875070 , lng:    17.821197509765625    } ,                                
                    {name: "Kaposvár,67-es sz. út", lat: 46.351163683366990 , lng:    17.782756090164185    } ,                                    
                    {name: "Kaposvár,Rózsa u.", lat: 46.346277729433150 , lng:    17.779365777969360    } ,                                  
                    {name: "Kaposvár,Erdősor u.", lat: 46.345687090029300 , lng:    17.773953080177307    } ,                                
                    {name: "Kaposvár,Gönczi F. u.", lat: 46.344759458522690 , lng:    17.774610221385956    } ,                                
                    {name: "Kaposvár,Városi Fürdő", lat: 46.351209967314425 , lng:    17.799356281757355    } ,                            
                    {name: "Kaposvár,Hajnóczy u. csp.", lat: 46.366816530326750 , lng:    17.765412926673890    } ,                                
                    {name: "Kaposvár,Jutai u. 24.", lat: 46.370247858398170 , lng:    17.768795192241670    } ,                                
                    {name: "Kaposvár,Jutai u. 45.", lat: 46.376943324463234 , lng:    17.763591706752777    } ,                                
                    {name: "Kaposvár,Raktár u. 2.", lat: 46.378262704506820 , lng:    17.763543426990510    } ,                         
                    {name: "Kaposvár,Kecelhegyalja u. 6.", lat: 46.363492341385500 , lng:    17.761067748069763    } ,                       
                    {name: "Kaposvár,Kőrösi Cs. S. u. 109.", lat: 46.358611191864384 , lng:    17.760450839996338    } ,             
                    {name: "Kaposvár,Kecelhegyi iskola", lat: 46.353500048084380 , lng:    17.765681147575380    } ,                        
                    {name: "Kaposvár,Kőrösi Cs. S. u. 45.", lat: 46.352144894660360 , lng:    17.762121856212616    } ,                                  
                    {name: "Kaposvár,Kenese tér", lat: 46.348660589113850 , lng:    17.763318121433258    } ,                                     
                    {name: "Kaposvár,Eger u.", lat: 46.348264378775690 , lng:    17.768146097660065    } ,                                
                    {name: "Kaposvár,Kapoli A. u.", lat: 46.347679315267825 , lng:    17.763312757015230    } ,                            
                    {name: "Kaposvár,Egyenesi u. 42.", lat: 46.345140881766255 , lng:    17.763232290744780    } ,                              
                    {name: "Kaposvár,Beszédes J. u.", lat: 46.341809819016056 , lng:    17.763240337371826    } ,                                 
                    {name: "Kaposvár,Állatkorház", lat: 46.352109719465574 , lng:    17.771563231945038    } ,                                  
                    {name: "Kaposvár,Kölcsey u.", lat: 46.352794706028230 , lng:    17.774274945259094    } ,                                 
                    {name: "Kaposvár,Tompa M. u.", lat: 46.353674068084040 , lng:    17.778663039207460    } ,                                
                    {name: "Kaposvár,Vasútállomás", lat: 46.352903932821600 , lng:    17.796105444431305    } ,                                
                    {name: "Kaposvár,Baross Gábor utca", lat: 46.352929851011720 , lng:    17.800327241420746    } ,                                
                    {name: "Kaposvár,Csalogány utca.", lat: 46.351143318417705 , lng:    17.808754742145540    } ,                                
                    {name: "Kaposvár,Vikár Béla. utca.", lat: 46.350356485021180 , lng:    17.812102138996124    } ,                                                                     
                    {name: "Kaposvár,Fő utca 48.", lat: 46.356810035658340 , lng:    17.798160016536713    } ,                                
                    {name: "Kaposvár,Fő utca. 37.", lat: 46.356717477209365 , lng:    17.795362472534180    } ,                                   
                    {name: "Kaposvár,Hársfa utca.", lat: 46.357235802504250 , lng:    17.802070677280426    } ,                              
                    {name: "Kaposvár,Hősök temploma", lat: 46.357913320297510 , lng:    17.807663083076477    } ,                                     
                    {name: "Kaposvár,Gyár utca.", lat: 46.356928510244230 , lng:    17.814457118511200    } ,                            
                    {name: "Kaposvár,Pécsi úti iskola", lat: 46.356136206566090 , lng:    17.818520665168762    } ,                                  
                    {name: "Kaposvár,Nádasdi utca.",  lat: 46.355023629907160 , lng:    17.825062572956085    } ,                               
                    {name: "Kaposvár,Móricz Zs. utca.", lat: 46.353829574848916 , lng:    17.835308611392975    } ,                               
                    {name: "Kaposvár,Pécsi utca. 227.", lat: 46.357420917489460 , lng:    17.839656472206116    } ,                             
                    {name: "Kaposvár,Várhegy feljáró", lat: 46.359329416424664 , lng:    17.843674421310425    } ,                                      
                    {name: "Kaposvár,Nap", lat: 46.350647151854060 , lng:    17.828941047191620    } ,                                          
                    {name: "Kaposvár,Hold utca", lat: 46.346305502288780 , lng:    17.834662199020386    } ,                
                    {name: "Kaposvár,Magyar Nobel-díjasok tere", lat: 46.348853138895365 , lng:    17.763251066207886    } ,                                
                    {name: "Kaposvár,Bartók Béla utca.", lat: 46.351437683765035 , lng:    17.790352106094360    } ,                              
                    {name: "Kaposvár,Táncsics Mihály utca", lat: 46.345585255004316 , lng:    17.787329256534576    } ,                                 
                    {name: "Kaposvár,Zichy Mihály utca", lat: 46.342183856188420 , lng:    17.788951992988586    } ,                                 
                    {name: "Kaposvár,Aranyeső utca.", lat: 46.337669315816115 , lng:    17.790381610393524    } ,                                    
                    {name: "Kaposvár,Jókai utca", lat: 46.345764854829700 , lng:    17.787168323993683    } ,                                   
                    {name: "Kaposvár,Szegfű utca",  lat: 46.345566739524855 , lng:    17.783179879188538    } ,                                  
                    {name: "Kaposvár,Gyertyános", lat: 46.330263403253590 , lng:    17.789416015148163    } ,                             
                    {name: "Kaposvár,Kertbarát felső", lat: 46.325108859259660 , lng:    17.787289023399353    } ,                              
                    {name: "Kaposvár,Kertbarát alsó", lat: 46.320153890054550 , lng:    17.784829437732697    } ,                                  
                    {name: "Kaposvár,Szőlőhegy", lat: 46.312925313409810 , lng:    17.786090075969696    } ,                            
                    {name: "Kaposvár,Fenyves utca 37/A", lat: 46.307659818792430 , lng:    17.782949209213257    } ,                               
                    {name: "Kaposvár,Fenyves utca 31", lat: 46.305945922572850 , lng:    17.783346176147460    } ,                          
                    {name: "Kaposvár,Kórház célgazdaság", lat: 46.313577443568010 , lng:    17.779859304428100    } ,                              
                    {name: "Kaposvár,Fenyves utca. 63.", lat: 46.308354626297070 , lng:    17.782509326934814    } ,                                
                    {name: "Kaposvár,Mező utca csp.", lat: 46.364166079764190 , lng:    17.813687324523926    } ,                                     
                    {name: "Kaposvár,Izzó utca", lat: 46.366396390664846 , lng:    17.815342247486115    } ,                              
                    {name: "Kaposvár,Guba Sándor utca 81.", lat: 46.373641958986180 , lng:    17.821240425109863    } ,                              
                    {name: "Kaposvár,Guba Sándor utca 57.", lat: 46.368658073539770 , lng:    17.817276120185852    } ,                           
                    {name: "Kaposvár,Villamossági Gyár", lat: 46.377739027323290 , lng:  17.823745608329773      } ,   
                    {name: "Kaposvár,Toponár  posta", lat: 46.390649998518434 , lng:    17.827809154987335    } ,                                                                                         
                    {name: "Kaposvár,Toponár  Orci elágazás", lat: 46.3942925677315   , lng:    17.833487391471863    } ,                                         
                    {name: "Kaposvár,Toponári utca 182.", lat: 46.401804483330140 , lng:    17.834061384201050    } ,                                        
                    {name: "Kaposvár,Toponári utca 238.", lat: 46.405344584373870 , lng:    17.835268378257750    } ,                                                                                      
                    {name: "Kaposvár,Erdei F. u.", lat: 46.396229375766644 , lng:    17.845348119735718    } ,                                                                                     
                    {name: "Kaposvár,Szabó P. u.", lat: 46.392585085872410 , lng:    17.844530045986176    } ,                                                                                  
                    {name: "Kaposvár,Orci út 14.", lat: 46.395408044363904 , lng:    17.841429412364960    } ,                                                                                  
                    {name: "Kaposvár,Répáspuszta", lat: 46.429838000000000 , lng:    17.840512000000000    } ,                                                                             
                    {name: "Kaposvár,Kenyérgyár u. 1.", lat: 46.362879676470875 , lng:    17.816699445247650    } ,                                                                             
                    {name: "Kaposvár,Kenyérgyár u. 3.", lat: 46.364739861392500 , lng:    17.818161249160767    } ,                                                                               
                    {name: "Kaposvár,Dombóvári u. 4.", lat: 46.363947670980195 , lng:    17.833637595176697    } ,                                                                    
                    {name: "Kaposvári Egyetem forduló", lat: 46.384574192377820 , lng:    17.826073765754700    } ,                                                                                     
                    {name: "Kaposvár,Virág u.", lat: 46.358487167595270 , lng:    17.803862392902374    } ,                                                                                 
                    {name: "Kaposvár,Pázmány P. u. 1.", lat: 46.360912068665720 , lng:    17.801375985145570    } ,                                                                               
                    {name: "Kaposvár,Vöröstelek u.", lat: 46.364267880170260 , lng:    17.799975872039795    } ,                                                                                     
                    {name: "Kaposvár,Hegyi u.", lat: 46.367684561948180 , lng:    17.797811329364777    } ,                                                                           
                    {name: "Kaposvár,Tallián Gy. u. 4.", lat: 46.357163607490010 , lng:    17.797277569770813    } ,                                                                                      
                    {name: "Kaposvár,Kórház", lat: 46.360229034900560 , lng:    17.797264158725740    } ,                                                                          
                    {name: "Kaposvár,Tallián Gy. u. 56.", lat: 46.362713089656480 , lng:    17.797266840934753    } ,                                                                          
                    {name: "Kaposvár,Tallián Gy. u. 82.", lat: 46.364639912768110 , lng:   17.797229290008545     } ,                                                                                  
                    {name: "Kaposvár,ÁNTSZ", lat: 46.365172969985040 , lng:    17.789059281349182    } ,                                                                                  
                    {name: "Kaposvár,Rendőrség", lat: 46.364528858526550 , lng:    17.793779969215393    } ,                                                                         
                    {name: "Kaposvár,Szent Imre utca 29.", lat: 46.361678389067265 , lng:    17.793796062469482    } ,                                                                                         
                    {name: "Kaposvár,Szent Imre utca 13.", lat: 46.360230885952110 , lng:    17.793844342231750    } ,                                                                                              
                    {name: "Kaposvár,Széchenyi tér", lat: 46.356919254426460 , lng:    17.794136703014374    } ,                                                                                                    
                    {name: "Kaposvár,Zárda u.",lat: 46.358837026377685 , lng:  17.787715494632720      } ,                                                      
                    {name: "Kaposvár,Honvéd u.", lat: 46.363140661458800 , lng: 17.787967622280120       },                                              
                    {name: "Kaposvár,Arany János tér", lat: 46.366823933639840 , lng:    17.788404822349550},                                                                                  
                    {name: "Kaposvár,Losonc-köz", lat: 46.370183083435110 , lng:    17.787884473800660    } ,                                                                                     
                    {name: "Kaposvár,Brassó u.", lat: 46.372092987227674 , lng:    17.787409722805023    } ,                                                                                            
                    {name: "Kaposvár,Nagyszeben u.", lat: 46.373155249773944 , lng:    17.787109315395355    } ,                                                                            
                    {name: "Kaposvár,Somssich P. u.", lat: 46.360545563804600 , lng:    17.789102196693420    } ,                                                                                           
                    {name: "Kaposvár,Pázmány P. u.", lat: 46.365032302613560 , lng: 17.799077332019806       } ,                                                        
                    {name: "Kaposvár,Kisgát", lat: 46.365048960610670 , lng:    17.808749377727510    } ,                                                                  
                    {name: "Kaposvár,Arany János utca", lat: 46.366792469552290 , lng:    17.784512937068940    } ,                                                                               
                    {name: "Kaposvár,Rózsa utca", lat: 46.345850025674650 , lng:    17.778743505477905    } ,                     
                    {name: "Kaposvár,Corso", lat: 46.355392023023086 , lng: 17.785899639129640    } ,
                ];

               

                function initMap() {
                    const kaposvar = { lat: 46.359997, lng: 17.796976 };
                    
                    map = new google.maps.Map(document.getElementById("map"), {
                        zoom: 13,
                        center: kaposvar,
                        styles: [
                            {
                                featureType: "transit.station",
                                elementType: "labels.icon",
                                stylers: [{ visibility: "on" }]
                            }
                        ]
                    });

                    directionsService = new google.maps.DirectionsService();
                    directionsRenderer = new google.maps.DirectionsRenderer({
                        map: map,
                        suppressMarkers: false,
                        polylineOptions: {
                            strokeColor: "#001F3F",
                            strokeWeight: 5
                        }
                    });

                    // Add markers for Kaposvár bus stops
                    kaposvarBusStops.forEach(stop => {
                        new google.maps.Marker({
                            position: { lat: stop.lat, lng: stop.lng },
                            map: map,
                            title: stop.name
                    });
                });

                }
                document.getElementById("routeBtn").onclick = function() {
                    const start = document.getElementById("start").value;

                    const request = {
                        origin: start,
                        travelMode: 'TRANSIT',
                        transitOptions:{
                            modes: ['BUS'],
                            routingPreference: 'FEWER_TRANSFERS'
                        },
                        unitSystem: google.maps.UnitSystem.IMPERIAL
                    };

                    directionsService.route(request, function(result, status) {
                        if (status == "OK") {
                            directionsRenderer.setDirections(result);
                            updateSchedule(result);
                        } else {
                            alert("Útvonal nem található: " + status);
                        }
                    });
                };

                function updateSchedule(result) {
                    const scheduleBody = document.getElementById("schedule-body");
                    scheduleBody.innerHTML = ''; // Ürítjük a meglévő menetrendet

                    const legs = result.routes[0].legs;
                    legs.forEach(leg => {
                        leg.steps.forEach(step => {
                            const row = document.createElement("tr");
                            row.innerHTML = `
                                <td>${step.travel_mode}</td>
                                <td>${step.duration.text}</td>
                                <td>${step.instructions || 'N/A'}</td>
                            `;
                            scheduleBody.appendChild(row);
                        });
                    });
                }

                window.onload = initMap;
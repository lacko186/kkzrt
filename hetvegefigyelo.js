// Hétvégén közlekedő járatok
const weekendRoutes = [13, 31, 32, 33, 41, 42, 47, 51, 61, 62, 70, 71, 72, 75, 83, 87, 88];

// Csak egy irányba közlekedő járatok
const oneWayRoutes = [13, 32, 33, 43, 44, 74, 85];

function isWeekend(date) {
    const day = date.getDay();
    return day === 0 || day === 6; // 0 = vasárnap, 6 = szombat
}

function validateRoute(routeValue, date) {
    // Eltávolítjuk a "vissza" szöveget és átalakítjuk számmá
    const routeNumber = parseInt(routeValue.split(' ')[0]);
    
    if (isWeekend(date)) {
        // Ellenőrizzük, hogy hétvégén közlekedik-e a járat
        if (!weekendRoutes.includes(routeNumber)) {
            return {
                valid: false,
                message: 'Ez a járat hétvégén nem közlekedik!'
            };
        }
        
        // Ellenőrizzük az egy irányú járatokat
        if (oneWayRoutes.includes(routeNumber) && routeValue.includes('vissza')) {
            return {
                valid: false,
                message: 'Ez a járat hétvégén csak egy irányban közlekedik!'
            };
        }
    }
    
    return {
        valid: true,
        message: ''
    };
}

// Példa használat:
document.addEventListener('DOMContentLoaded', () => {
    const routeSelect = document.querySelector('select'); // A select elem kiválasztása
    const dateInput = document.getElementById('travel-time'); // A dátumválasztó elem kiválasztása
    
    function validateSelection() {
        if (!dateInput.value || !routeSelect.value) return;
        
        const selectedDate = new Date(dateInput.value);
        const result = validateRoute(routeSelect.value, selectedDate);
        
        if (!result.valid) {
            alert(result.message);
            routeSelect.value = ''; // Visszaállítjuk az alapértelmezett értékre
        }
    }
    
    // Figyeljük mindkét mező változását
    routeSelect.addEventListener('change', validateSelection);
    dateInput.addEventListener('change', validateSelection);
});
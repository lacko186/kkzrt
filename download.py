import requests
from requests.auth import HTTPBasicAuth
import logging
from pathlib import Path
from typing import Optional, Dict, Tuple
import sys
import zipfile
import hashlib
from io import BytesIO
import json

class GTFSDownloader:
    """GTFS adatok letöltésére és validálására szolgáló osztály."""
    
    def __init__(self, base_url: str, api_key: str):
        self.base_url = base_url.rstrip('/')  # Eltávolítjuk az esetleges záró /-t
        self.api_key = api_key
        self.setup_logging()
    
    def setup_logging(self) -> None:
        logging.basicConfig(
            level=logging.INFO,
            format='%(asctime)s - %(levelname)s - %(message)s'
        )
        self.logger = logging.getLogger(__name__)

    def parse_json_response(self, response: requests.Response) -> Tuple[bool, dict]:
        """
        JSON válasz feldolgozása és értelmezése.
        
        Returns:
            Tuple[bool, dict]: (sikeres-e, válasz adatok vagy hibaüzenet)
        """
        try:
            data = response.json()
            self.logger.info(f"Szerver válasz tartalma: {json.dumps(data, indent=2)}")
            
            if isinstance(data, dict):
                if data.get('result') == 'success' and 'data' in data:
                    return True, data['data']
                elif 'error' in data:
                    return False, {'error': data['error']}
                
            return False, {'error': 'Ismeretlen válasz formátum'}
            
        except json.JSONDecodeError as e:
            return False, {'error': f"Hibás JSON válasz: {str(e)}"}

    def get_gtfs_info(self, config_id: str, timetable_period: str) -> Tuple[bool, dict]:
        """
        GTFS információk lekérése az API-ról.
        """
        params = {
            "config_id": config_id,
            "timetable_period": timetable_period
        }
        
        headers = {
            "Authorization": f"Basic {self.api_key}",
            "Accept": "application/json",
            "User-Agent": "GTFSDownloader/1.0"
        }
        
        try:
            self.logger.info(f"GTFS információk lekérése: {config_id}")
            response = requests.get(
                f"{self.base_url}/info",
                params=params,
                headers=headers,
                timeout=30
            )
            response.raise_for_status()
            return self.parse_json_response(response)
            
        except requests.RequestException as e:
            self.logger.error(f"Hiba történt az információk lekérése során: {str(e)}")
            return False, {'error': str(e)}

    def download_gtfs_data(self, config_id: str, timetable_period: str, checksum: str) -> Optional[bytes]:
        """
        GTFS adatok letöltése a /download végpontról.
        """
        params = {
            "config_id": config_id,
            "timetable_period": timetable_period,
            "checksum": checksum
        }
        
        headers = {
            "Authorization": f"Basic {self.api_key}",
            "Accept": "application/zip",
            "User-Agent": "GTFSDownloader/1.0"
        }
        
        try:
            download_url = f"{self.base_url}/download"
            self.logger.info(f"GTFS adatok letöltése: {download_url}")
            self.logger.info(f"Paraméterek: {params}")
            
            response = requests.get(
                download_url,
                params=params,
                headers=headers,
                timeout=30
            )
            response.raise_for_status()
            
            content_type = response.headers.get('Content-Type', '').lower()
            if 'application/zip' not in content_type:
                self.logger.warning(f"Váratlan Content-Type a letöltésnél: {content_type}")
            
            return response.content
            
        except requests.RequestException as e:
            self.logger.error(f"Hiba történt a GTFS adatok letöltése során: {str(e)}")
            return None

    def download_gtfs(self, 
                     config_id: str, 
                     timetable_period: str, 
                     output_path: Optional[Path] = None) -> bool:
        """
        Teljes GTFS letöltési folyamat végrehajtása.
        """
        # 1. GTFS információk lekérése
        success, info = self.get_gtfs_info(config_id, timetable_period)
        if not success:
            self.logger.error(f"Nem sikerült lekérni a GTFS információkat: {info.get('error')}")
            return False
        
        self.logger.info("GTFS információk sikeresen lekérve:")
        self.logger.info(f"  Létrehozva: {info.get('created')}")
        self.logger.info(f"  Időszak: {info.get('trips_begin')} - {info.get('trips_end')}")
        self.logger.info(f"  Járatok száma: {info.get('trips_count')}")
        self.logger.info(f"  Checksum: {info.get('checksum')}")
        
        # 2. GTFS adatok letöltése
        content = self.download_gtfs_data(
            config_id, 
            timetable_period, 
            info.get('checksum')
        )
        
        if not content:
            self.logger.error("Nem sikerült letölteni a GTFS adatokat")
            return False
        
        # 3. Adatok mentése
        if not output_path:
            output_path = Path(f"{config_id}_gtfs_data.zip")
        
        try:
            output_path.parent.mkdir(parents=True, exist_ok=True)
            with open(output_path, "wb") as file:
                file.write(content)
            
            md5_hash = hashlib.md5(content).hexdigest()
            self.logger.info(f"Adatok sikeresen mentve: {output_path}")
            self.logger.info(f"Fájl MD5 hash: {md5_hash}")
            return True
            
        except IOError as e:
            self.logger.error(f"Hiba történt a fájl mentése során: {str(e)}")
            return False

def main():
    # Konfigurációs értékek
    API_URL = "https://api.menetbrand.com/hungary/gtfs"  # Módosított alap URL
    API_KEY = "cbrgwtzhljucjysmepxkysxsnpqddhetgrnsunjudfpfurvrhrbyprpurdrqltie"
    CONFIG_ID = "kaposvar"
    TIMETABLE_PERIOD = "60"
    
    # GTFS letöltő inicializálása
    downloader = GTFSDownloader(API_URL, API_KEY)
    
    # Letöltés indítása
    success = downloader.download_gtfs(
        config_id=CONFIG_ID,
        timetable_period=TIMETABLE_PERIOD
    )
    
    # Kilépési kód beállítása
    sys.exit(0 if success else 1)

if __name__ == "__main__":
    main()
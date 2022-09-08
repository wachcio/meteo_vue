/*
 * meteo_sensors.h
 *
 *  Created on: 14 paŸ 2016
 *      Author: avrtech
 *      Strona www: http://avrtech.pl
 *
 *      Obs³uga czujników dla u¿ytku prywatnego wymaga pozostawienia stopki.
 *      Aby wykorzystaæ bibliotekê do celów komercyjnych proszê o kontakt poprzez stronê www.
 */

#ifndef METEO_SENSORS_H_
#define METEO_SENSORS_H_


// zmienne - wiatr
  uint32_t spd_wind_kmh, spd_wind_kmh_max, spd_wind_kmh_j, spd_wind_kmh_d, spd_windm_kmh_j, spd_windm_kmh_d;
//volatile uint32_t tmp_spd_wind;								//licznik impulsów z czujnika prêdkoœci wiatru
//uint32_t max_wind_E EEMEM, max_wind_d_E EEMEM, max_wind_j_E EEMEM; //zmienna mksymalny wiatr w EEPROM
  volatile uint32_t tmp_imp_rainfall;		//licznik impulsów z czujnika opadów
  volatile uint32_t tmp_spd_wind;			//licznik impulsów z czujnika prêdkoœci wiatru
  volatile uint32_t impulsy_wiatr[60];		//tablica impulsów wiatromierza
  volatile uint32_t srednia_wiatr;
  volatile uint64_t suma_imp_wiatr, opady_imp, poryw_wiatru_imp;


  // zmienne - opad
  uint32_t rainfall_mm, rainfall_mm_j, rainfall_mm_d;
  uint32_t rainfall_max_mm, rainfall_max_mm_j, rainfall_max_mm_d;

//  extern volatile uint32_t tmp_imp_rainfall;       //licznik impulsów z czujnika opadu

//Zmienne ADC
  uint16_t pm, adc;							// zmienne na potrzeby kierunku wiatru - pomiar ADC

  uint8_t av_cz_d, av_cz_u;
  uint32_t av;

  char buffer_out[32];						// bufor wyjsciowy nRF
  char buffer_data[15];						// bufor wyjsciowy nRF
  char buffer_KW[5];							// bufor kierunku wiatru
  char buffer_KW_AV[5];							// bufor kierunku wiatru
  char buffer_KW_DE[5];							// bufor kierunku wiatru
  char buffer_KW_ST[5];							// bufor kierunku wiatru
  char direction_string[5];						// bufor kierunku wiatru
  char direction_degree[6];						// zmienna stopni kierunku wiatru
  uint16_t wartosc_ADC(uint8_t pin);			//deklaracja funkcji pomiaru ADC



//  uint8_t http=1;
//  uint8_t operacja;



//  char delim2[] = "</td>";
//
//  char d1php[] = "#";
//  char d2php[] = "#";

  uint16_t P1, P2, P3, P4;
  uint8_t flaga_wyslij_dane;

  uint8_t tik, sekundy_pomiaru;

  //potwierdzenie n-link
  #define  NLINK_PIN (1<<PB0)

  //pomiar temperatury
  uint8_t s1_flag, czujniki_cnt;
  uint8_t subzero, cel, cel_fract_bits;
  int32_t temperatura[3];


  volatile uint8_t dominanta_liczba;
  volatile uint8_t dominanta_ilosc;

  //************************ deklaracje funkcji *****************




void init_sensors (void);					// inicjalizacja na potrzeby czujników
void kierunek_wiatru( void );				// sprawdzenie kierunku wiatru
void predkosc_wiatru (void);						// funkcja mierz¹ca i przeliczaj¹ca prêdkoœæ wiatru w km/h
void srednia_predkosc_wiatru (void);
void pomiar_opadu (void);                        // funkcja mierz¹ca i przeliczaj¹ca iloœæ opadu w mm

void wyswietl_LCD_wiatr (void);
void wyswietl_LCD_opady (void);

void wyslij_na_RS232(void);

void wyslij_dane_na_serwer ( uint32_t predkosc_wiatru, uint32_t poryw_wiatru,  uint32_t kierunek_wiatru, uint32_t opady , int32_t temperatura, int32_t temperatura2 );
//uint8_t strParse( int znak, TPSTR * wpstr );
void wifi_reprogram ( char * myhttp );
void pomiar_temperatury (void);
void display_temp(uint8_t x);
void dominanta (void);


#endif /* METEO_SENSORS_H_ */



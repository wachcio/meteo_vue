

/*
 * meteo_sensors.c
 *
 *  Created on: 14 paŸ 2016
 *      Author: avrtech
 *      Strona www: http://avrtech.pl
 *
 *      Obs³uga czujników dla u¿ytku prywatnego wymaga pozostawienia stopki.
 *      Aby wykorzystaæ bibliotekê do celów komercyjnych proszê o kontakt poprzez stronê www.
 */


#include <avr/io.h>
#include <avr/interrupt.h>
#include <util/delay.h>
#include <stdlib.h>
#include <stdio.h>
#include <string.h>
#include <avr/eeprom.h>
#include "meteo_sensors.h"                // do³¹czenie deklaracji
#include "../LCD/lcd44780.h"
#include "../MK_USART/mkuart.h"
#include "../MK_TERMINAL/mk_term.h"
#include "../1Wire/ds18x20.h"



//Sposób pod³¹czenia
//opady - PD3 i GND
//kierunek wiatru - PA0, GND i przez rezystor VCC
//prêdkoœc wiatru PD2 i GND

// zmienne - wiatr (1 impuls na 1 sek = 2,4km/h)
//volatile uint32_t tmp_spd_wind;                                //licznik impulsów z czujnika prêdkoœci wiatru
//extern uint32_t spd_wind_kmh, spd_wind_kmh_max ;                        //zmienne wyniku prêdkoœci wiatru
// uint32_t max_wind_E EEMEM, max_wind_d_E EEMEM, max_wind_j_E EEMEM; //zmienna mksymalny wiatr w EEPROM

uint32_t EEMEM max_wind_E; //zmienna mksymalny wiatr w EEPROM

//void  save_to_eeprom(uint32_t * adres, uint32_t value){
//
//        eeprom_write_byte ( adres , value );
//}
// zmienne - opad (1 impuls na 1 sek = 0,2794mm)
//volatile uint32_t tmp_imp_rainfall;        //licznik impulsów z czujnika opadów
//extern uint32_t rainfall_mm, rainfall_mm_j, rainfall_mm_d;            //zmienna wyniku opadu deszczu
//extern uint32_t rainfall_max_mm, rainfall_max_mm_j, rainfall_max_mm_d;            //zmienna wyniku opadu deszczu

uint8_t _wachcio_http=1;
enum{ _ip, _ip2, _usd, _eur, _chf };

//Zmienne do odbioru danych ze strony WWW
typedef struct{
        char * delim1;
        uint8_t d1len;
        char * delim2;
        uint8_t d2len;
        char outbuf[100];
        int8_t status;
} TPSTR;

 TPSTR tpstr;

uint8_t http;
uint8_t operacja;

uint8_t strParse( int znak, TPSTR * wpstr );

char delim2[] = "</td>";

char d1php[] = "#";
char d2php[] = "#";

//dominanta
// volatile uint8_t tablica_dominanta[60]= {4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5};
volatile uint8_t tablica_dominanta[60];


void pomiar_opadu (void) {



    rainfall_mm = tmp_imp_rainfall * 28;            // przelicz ilosc impulsow na mm bez przecinka
    rainfall_mm_d = rainfall_mm / 100;            // przesun przecinek o 1 w prawo pozbywajac sie dziesietnych
    rainfall_mm_j = rainfall_mm - (rainfall_mm_d * 100);    // oblicz dziesietne predkosci wiatru

    if(rainfall_mm >= rainfall_max_mm){                    // jezeli opad jest wieksza lub równa prêdkoœci max
        rainfall_max_mm = rainfall_mm;    // przypisz wartoœæ opadu wiatru do opadu max
        rainfall_max_mm_d = rainfall_max_mm / 100;            // przesun przecinek o 1 w prawo pozbywajac sie dziesietnych
            rainfall_max_mm_j = rainfall_max_mm - (rainfall_max_mm_d * 100);    // oblicz dziesietne predkosci wiatru


            }

//    wyswietl_LCD_opady();


    tmp_imp_rainfall = 0;


}

void wyswietl_LCD_opady (void){

    lcd_locate(1,5);
//    lcd_int(tmp_imp_rainfall);
//    lcd_str("Opady: ");
//    lcd_int(rainfall_mm_d);
//    lcd_str(",");
//    lcd_int(rainfall_mm_j);
//    lcd_str("mm");
    lcd_int(opady_imp);


////    test impulsów
//    lcd_locate(0,0);
//    lcd_str("Impulsy: ");
//    lcd_int(tmp_imp_rainfall);

}


void predkosc_wiatru (void) {


        spd_wind_kmh = tmp_spd_wind * 24;                    // przelicz ilosc impulsow na km/h bez przecinka

//        if (spd_wind_kmh >= max_wind_E){
//            max_wind_E = spd_wind_kmh_max;
//        }

        if(spd_wind_kmh >= spd_wind_kmh_max){                    // jezeli predkosc wiatru jest wieksza lub równa prêdkoœci max
            spd_wind_kmh_max = spd_wind_kmh;    // przypisz wartoœæ prêdkoœci wiatru do prêdkoœci max
//            max_wind_E = spd_wind_kmh_max;
//            save_to_eeprom(&max_wind_E, spd_wind_kmh);
            poryw_wiatru_imp = tmp_spd_wind;
        }

        spd_wind_kmh_d = spd_wind_kmh / 10;                    // przesun przecinek o 1 w prawo pozbywajac sie dziesietnych
        spd_wind_kmh_j = spd_wind_kmh - (spd_wind_kmh_d * 10);            // oblicz dziesietne predkosci wiatru

//        spd_windm_kmh_d = eeprom_read_byte (&max_wind_E) /10;                // przesun przecinek o 1 w prawo pozbywajac sie dziesietnych
//        spd_windm_kmh_j = eeprom_read_byte (&max_wind_E) - (spd_windm_kmh_d * 10);        // oblicz dziesietne predkosci wiatru

        spd_windm_kmh_d = spd_wind_kmh_max / 10;                // przesun przecinek o 1 w prawo pozbywajac sie dziesietnych
        spd_windm_kmh_j = spd_wind_kmh_max - (spd_windm_kmh_d * 10);        // oblicz dziesietne predkosci wiatru


        impulsy_wiatr[tik] = tmp_spd_wind;

        suma_imp_wiatr=suma_imp_wiatr+tmp_spd_wind;

//        uart_puts("Prêdkoœæ wiatru: ");
//        uart_putint(spd_wind_kmh_d, 10);
//        uart_puts(",");
//        uart_putint(spd_wind_kmh_j, 10);
//        uart_puts("km/h, ");
//        uart_puts("prêdkoœæ maksymalna: ");
//        uart_putint(spd_windm_kmh_d, 10);
//        uart_puts(",");
//        uart_putint(spd_windm_kmh_j, 10);
//        uart_puts("km/h");
//        uart_puts("\r");
//        wyswietl_LCD_wiatr();    //wyœwietlanie danych
//        wyswietl_LCD_opady();

        tmp_spd_wind = 0;                            // wyzeruj licznik impulsów
}

void wyswietl_LCD_wiatr (void) {

        lcd_cls();
            //Wyœwietlanie na LCD
        lcd_locate(0,0);
//        lcd_str("W ");
//        if (spd_wind_kmh_d<10)
//        {
//            lcd_locate(0,4);
//        } else {
//            lcd_locate(0,3);
//        }
//        lcd_int(spd_wind_kmh_d);
//        lcd_str(",");
//        lcd_int(spd_wind_kmh_j);
////lcd_str("km/h");
        lcd_int(tmp_spd_wind);

        lcd_locate(0,8);
        lcd_str("max: ");
        lcd_int(spd_windm_kmh_d);
        lcd_str(",");
        lcd_int(spd_windm_kmh_j);
//        lcd_str("km/h");
        lcd_locate(1,0);
        lcd_int(suma_imp_wiatr);

////        lcd_locate(1,0);
//        lcd_locate(0,0);
//        lcd_str("   ");
//        lcd_locate(0,0);
//        lcd_str(direction_string);
//        lcd_locate(1,0);
//        lcd_str("   ");
//        lcd_locate(1,0);
//        lcd_int(adc);

//        wyswietl_LCD_opady();    //wyœwietlanie danych
//        lcd_locate(1,5);
//        lcd_str("Opady: ");


//        //    test impulsów
//            lcd_locate(0,0);
//            lcd_str("Impulsy: ");
//            lcd_int(tmp_spd_wind);
}

void wyslij_na_RS232(void){

    //wyœwietlanie na UART
//    tr_cursor_hide(1);
//    tr_locate(1,0);
    uart_puts ("Wiatr: ");
    uart_puts (direction_string);
    uart_puts ("ADC: ");
    uart_putint (adc, 10);
    uart_puts (", z prêdkoœci¹: ");
    uart_putint(spd_wind_kmh_d, 10);
    uart_puts (",");
    uart_putint(spd_wind_kmh_j, 10);
    uart_puts ("km/h, maksymalna prêdkoœæ: ");
    uart_putint(spd_windm_kmh_d, 10);
    uart_puts (",");
    uart_putint(spd_windm_kmh_j, 10);
    uart_puts ("km/h    \r\n");

    uart_puts ("Opady: ");
    uart_putint(rainfall_mm_d, 10);
    uart_puts (",");
    uart_putint(rainfall_mm_j, 10);
    uart_puts ("mm/min ");

    uart_puts ("Opady max: ");
    uart_putint(rainfall_max_mm_d, 10);
    uart_puts (",");
    uart_putint(rainfall_max_mm_j, 10);
    uart_puts ("mm/min");

     uart_puts ("Temperatura: ");
    uart_putint( temperatura[0], 10);


//    //Dane na Android
//    uart_puts ("wachcio_pogoda");
//    uart_puts (";");
//    uart_puts (direction_string);
//    uart_puts (";");
//    uart_putint (adc, 10);
//    uart_puts (";");
//    uart_putint(spd_wind_kmh_d, 10);
//    uart_puts (";");
//    uart_putint(spd_wind_kmh_j, 10);
//    uart_puts (";");
//    uart_putint(spd_windm_kmh_d, 10);
//    uart_puts (";");
//    uart_putint(spd_windm_kmh_j, 10);
//    uart_puts (";");
//    uart_putint(rainfall_mm_d, 10);
//    uart_puts (";");
//    uart_putint(rainfall_mm_j, 10);
//    uart_puts (";");


}
// odczyt wartoœci ADC
uint16_t wartosc_ADC(uint8_t pin){
    ADMUX |= (ADMUX & 0xF8) | pin;    // ustawienie wybranego pinu ADC
    ADCSRA |= (1<<ADSC);            // start pomiaru
    while( ADCSRA & (1<<ADSC) );    // oczekiwanie na koniec pomiaru
    return ADCW;
}

// sprawdzenie kierunku wiatru
void kierunek_wiatru( void ){    pm = wartosc_ADC(0);




    adc = pm;

    av = adc * 49;
    av_cz_d = av/10000;
    av_cz_u = (av/100) % 100;

    sprintf(buffer_KW, "%i", pm);
    sprintf(buffer_KW_AV, "%i.%i", av_cz_d, av_cz_u);


//    if ((adc > 760) && (adc < 799)) {strcpy(direction_degree, "0");   strcpy(direction_string, "N");};
//    if ((adc > 380) && (adc < 430)) {strcpy(direction_degree, "22.5");   strcpy(direction_string, "NNE");};
//    if ((adc > 450) && (adc < 470)) {strcpy(direction_degree, "45");  strcpy(direction_string, "NE");};
//    if ((adc > 70) && (adc < 85)) {strcpy(direction_degree, "67.5");  strcpy(direction_string, "ENE");};
//    if ((adc > 85) && (adc < 100))  {strcpy(direction_degree, "90");  strcpy(direction_string, "E");};
//    if ((adc > 60) && (adc < 69))  {strcpy(direction_degree, "112.5");  strcpy(direction_string, "ESE");};
//    if ((adc > 170) && (adc < 199)) {strcpy(direction_degree, "135"); strcpy(direction_string, "SE");};
//    if ((adc > 110) && (adc < 137)) {strcpy(direction_degree, "157.5"); strcpy(direction_string, "SSE");};
//    if ((adc > 270) && (adc < 299)) {strcpy(direction_degree, "180"); strcpy(direction_string, "S");};
//    if ((adc > 230) && (adc < 260)) {strcpy(direction_degree, "202.5"); strcpy(direction_string, "SSW");};
//    if ((adc > 610) && (adc < 640)) {strcpy(direction_degree, "225"); strcpy(direction_string, "SW");};
//    if ((adc > 590) && (adc < 605)) {strcpy(direction_degree, "247.5"); strcpy(direction_string, "WSW");};
//    if ((adc > 930) && (adc < 960)) {strcpy(direction_degree, "270"); strcpy(direction_string, "W");};
//    if ((adc > 810) && (adc < 830)) {strcpy(direction_degree, "292.5"); strcpy(direction_string, "WNW");};
//    if ((adc > 870) && (adc < 899)) {strcpy(direction_degree, "315"); strcpy(direction_string, "NW");};
//    if ((adc > 690) && (adc < 715)) {strcpy(direction_degree, "337.5"); strcpy(direction_string, "NNW");};

    if ((adc > 200) && (adc < 280)) {strcpy(direction_degree, "0");   strcpy(direction_string, "N"); tablica_dominanta[tik] = 0;};
    if ((adc > 591) && (adc < 680)) {strcpy(direction_degree, "22.5");   strcpy(direction_string, "NNE");tablica_dominanta[tik] = 1;};
    if ((adc > 500) && (adc < 590)) {strcpy(direction_degree, "45");  strcpy(direction_string, "NE");tablica_dominanta[tik] = 2;};
    if ((adc > 935) && (adc < 949)) {strcpy(direction_degree, "67.5");  strcpy(direction_string, "ENE");tablica_dominanta[tik] = 3;};
    if ((adc > 911) && (adc < 934))  {strcpy(direction_degree, "90");  strcpy(direction_string, "E");tablica_dominanta[tik] = 4;};
    if ((adc > 950) && (adc < 990))  {strcpy(direction_degree, "112.5");  strcpy(direction_string, "ESE");tablica_dominanta[tik] = 5;};
    if ((adc > 801) && (adc < 870)) {strcpy(direction_degree, "135"); strcpy(direction_string, "SE");tablica_dominanta[tik] = 6;};
    if ((adc > 879) && (adc < 910)) {strcpy(direction_degree, "157.5"); strcpy(direction_string, "SSE");tablica_dominanta[tik] = 7;};
    if ((adc > 690) && (adc < 750)) {strcpy(direction_degree, "180"); strcpy(direction_string, "S");tablica_dominanta[tik] = 8;};
    if ((adc > 751) && (adc < 800)) {strcpy(direction_degree, "202.5"); strcpy(direction_string, "SSW");tablica_dominanta[tik] = 9;};
    if ((adc > 350) && (adc < 400)) {strcpy(direction_degree, "225"); strcpy(direction_string, "SW");tablica_dominanta[tik] = 10;};
    if ((adc > 401) && (adc < 480)) {strcpy(direction_degree, "247.5"); strcpy(direction_string, "WSW");tablica_dominanta[tik] = 11;};
    if ((adc > 60) && (adc < 80)) {strcpy(direction_degree, "270"); strcpy(direction_string, "W");tablica_dominanta[tik] = 12;};
    if ((adc > 170) && (adc < 220)) {strcpy(direction_degree, "292.5"); strcpy(direction_string, "WNW");tablica_dominanta[tik] = 13;};
    if ((adc > 120) && (adc < 160)) {strcpy(direction_degree, "315"); strcpy(direction_string, "NW");tablica_dominanta[tik] = 14;};
    if ((adc > 290) && (adc < 345)) {strcpy(direction_degree, "337.5"); strcpy(direction_string, "NNW");tablica_dominanta[tik] = 15;};

    sprintf(buffer_KW_ST, "%s", direction_degree);
    sprintf(buffer_KW_DE, "%s", direction_string);

//    lcd_locate(10,1);
//    lcd_int(adc);

}

void wyslij_dane_na_serwer ( uint32_t predkosc_wiatru, uint32_t poryw_wiatru,  uint32_t kierunek_wiatru, uint32_t opady , int32_t temperatura,  int32_t temperatura2)
{
    if (1==flaga_wyslij_dane){

//                if( http != _wachcio_http ) wifi_reprogram( "meteo.wachcio.pl" );
//    wifi_reprogram( "delphi-archiwum.home.pl" );
                http = _wachcio_http;
                tpstr.delim1 = d1php;
                tpstr.d1len = strlen( d1php );
                tpstr.delim2 = d2php;
                tpstr.d2len = strlen( d2php );
                operacja = _ip2;
//PORTD ^= (1<<PD6);
//                P1=rand();
//                P2=rand();
//                P3=rand();
//                P4=rand();
// http://meteo.wachcio.pl/pogoda_test/index.php?TOKEN=7894561230&predkosc_wiatru=1&poryw_wiatru=1&kierunek_wiatru=1&opady=1&temperatura=1&temperatura2=1

//                uart_puts( "GET http://delphi-archiwum.home.pl/wachcio/pogoda_test/index.php?TOKEN=7894561230&predkosc_wiatru=" );
                uart_puts( "GET http://meteo.wachcio.pl/API/addSensorsAVR.php?TOKEN=7894561230&predkosc_wiatru= " );
                uart_putint( predkosc_wiatru, 10);
                uart_puts("&poryw_wiatru=" );
                uart_putint( poryw_wiatru, 10);
                uart_puts("&kierunek_wiatru=" );
                uart_putint( kierunek_wiatru, 10);
                uart_puts("&opady=" );
                uart_putint( opady, 10);
                uart_puts("&temperatura=" );
                uart_putint( temperatura, 10);
                uart_puts("&temperatura2=" );
                uart_putint( temperatura2, 10);
//                uart_puts(" HTTP/1.0\r\n\r\n" );

                tpstr.status = 0;
     lcd_cls();
                 lcd_locate(1,0);
                        lcd_str("wyslano");
                        flaga_wyslij_dane=0;

                        suma_imp_wiatr=0;
    spd_wind_kmh_max=0;
    opady_imp = 0;
    poryw_wiatru_imp = 0;
    dominanta_liczba = 0;
    dominanta_ilosc = 0;




    }
}

uint8_t strParse( int znak, TPSTR * wpstr )
{
        static uint8_t idx1, idx2;
        static uint8_t strend;
        char mzn=znak;

        if( wpstr->status < 0 || znak < 0 ) return 0;

        if( !wpstr->status )
        {
                char * dlm1 = wpstr->delim1;
                if( mzn == *(dlm1+idx1) )
                {
                        idx1++;
                        if( idx1 == wpstr->d1len )
                        {
                                wpstr->status = 1;
                                idx1 = 0;
                                idx2 = 0;
                        }
                } else idx1 = 0;
        }
        else if( wpstr->status )
        {
                wpstr->outbuf[idx1++] = mzn;
                if( idx1 > 99 ) idx1 = 0;
                char * dlm2 = wpstr->delim2;

                if( mzn == *(dlm2 + idx2) )
                {
                        idx2++;
                        if( 1 == wpstr->status ) wpstr->status = 2;
                        strend = idx1 - idx2;
                        if( idx2 == wpstr->d2len )
                        {
                                idx1 = 0;
                                idx2 = 0;
                                wpstr->status = -1;
                                wpstr->outbuf[ strend ] = 0;
                                return 1;
                        }
                }
                else
                {
                        idx2 = 0;
                        wpstr->status = 1;
                }
        }

        return 0;
}

void wifi_reprogram ( char * myhttp )
{
        lcd_cls();
        lcd_str("ATNEL-WIFI232-T");
        lcd_locate(1,0);
        lcd_str("change config");

        uart_putc('+');
        _delay_ms(150);
        uart_putc('+');
        _delay_ms(150);
        uart_putc('+');
        _delay_ms(150);
        uart_putc('a');
        _delay_ms(300);

        uart_puts("AT+NETP=TCP,Client,80,");
        uart_puts(myhttp);
        uart_puts("\r");
        _delay_ms(300);
        uart_puts("AT+Z\r");
        lcd_locate(1,0);
        lcd_str("Restart module! ");
        _delay_ms(1000);

        while(!( PINB & NLINK_PIN ));
        lcd_locate(1,0);
        lcd_str("nLink OK        ");

        _delay_ms(1000);
        _delay_ms(1500);


}

void srednia_predkosc_wiatru (void) {
    uint8_t i;
    uint64_t suma=0;

    for (i=0; i<sekundy_pomiaru; i++){
        suma=suma+impulsy_wiatr[i];
    }
    srednia_wiatr = suma / (sekundy_pomiaru-1);


}

void dominanta (void){

    uint8_t  n ,i, j, c, w;


        n = sizeof(tablica_dominanta);   //Obliczanie rozmiaru tablicy z odczytami czujnika dla tego przyk³adu mo¿na zastosowac n=60;

        dominanta_ilosc = 0;

        for(i = 0; i < n; i++)
        {
            w = tablica_dominanta[i];
            c = 0;

            for(j = 0; j < n; j++) if(w == tablica_dominanta[j]) c++;

            if(c > dominanta_ilosc)
            {
                dominanta_ilosc = c;  //iloœc wyst¹pieñ dominanty w zbiorze
                dominanta_liczba = w;  //dominanta
            }
        }

}

void pomiar_temperatury (void){
/* co trzy sekundy gdy reszta z dzielenia modulo 3 == 0 sprawdzaj iloœæ dostêpnych czujników */

            if( 0 == (tik%3) ) {
//PORTA ^= (1<<PA7); //dioda dla sprawdzenia poprawnoœci przerwania
                uint8_t *cl=(uint8_t*)gSensorIDs;    // pobieramy wskaŸnik do tablicy adresów czujników
                for( uint8_t i=0; i<MAXSENSORS*OW_ROMCODE_SIZE; i++) *cl++ = 0; // kasujemy ca³¹ tablicê
                czujniki_cnt = search_sensors();    // ponownie wykrywamy ile jest czujników i zape³niamy tablicê
//                lcd_locate(0,8);
//                lcd_int( czujniki_cnt );    // wyœwietlamy iloœæ czujników na magistrali

            }

            /* co trzy sekundy gdy reszta z dzielenia modulo 3 == 1 wysy³aj rozkaz pomiaru do czujników */
            if( 1 == (tik%3) ) DS18X20_start_meas( DS18X20_POWER_EXTERN, NULL );

            /* co trzy sekundy gdy reszta z dzielenia modulo 3 == 2 czyli jedn¹ sekundê po rozkazie konwersji
             *  dokonuj odczytu i wyœwietlania temperatur z 2 czujników jeœli s¹ pod³¹czone, jeœli nie
             *  to poka¿ komunikat o b³êdzie
             */
            if( 2 == (tik%3) ) {
                if( DS18X20_OK == DS18X20_read_meas(gSensorIDs[0], &subzero, &cel, &cel_fract_bits) ) display_temp(1);
                else {
//                    lcd_defchar_P(0x82, znak_l);
//                    lcd_defchar_P(0x83, znak_a);
//                    lcd_locate(1,0);
//                    lcd_str(" b\x82");
//                    lcd_str("\x83");
//                    lcd_str("d  ");
                }

                if( DS18X20_OK == DS18X20_read_meas(gSensorIDs[1], &subzero, &cel, &cel_fract_bits) ) display_temp(2);
                else {
//                    lcd_defchar_P(0x82, znak_l);
//                    lcd_defchar_P(0x83, znak_a);
//                    lcd_locate(1,9);
//                    lcd_str(" b\x82");
//                    lcd_str("\x83");
//                    lcd_str("d  ");
                }
            }

            /* zerujemy flagê aby tylko jeden raz w ci¹gu sekundy wykonaæ operacje */
            s1_flag=0;
         /* koniec sprawdzania flagi */
}

/* wyœwietlanie temperatury na pozycji X w drugiej linii LCD */
void display_temp(uint8_t x) {
//    lcd_defchar_P(0x81, znak_stopnie);
    lcd_locate(x-1,x);
    if(subzero) lcd_str("-");    /* jeœli subzero==1 wyœwietla znak minus (temp. ujemna) */
    else lcd_str(" ");    /* jeœli subzero==0 wyœwietl spacjê zamiast znaku minus (temp. dodatnia) */
    lcd_int(cel);    /* wyœwietl dziesiêtne czêœci temperatury  */
    lcd_str(".");    /* wyœwietl kropkê */
    lcd_int(cel_fract_bits); /* wyœwietl dziesiêtne czêœci stopnia */
//    lcd_str("\x81"); /* wyœwietl znak stopni */
//    lcd_str("C "); /* wyœwietl znak jednostek (C - stopnie Celsiusza) */

    if(subzero) {    /* jeœli subzero==1 wyœwietla znak minus (temp. ujemna) */

        temperatura[x] = ((10*cel)+cel_fract_bits)*-1;
    } else {

        temperatura[x] = (10*cel)+cel_fract_bits;

    }
}

void init_sensors (void) {
//    PORTC ^= (1<<PC3);
    tik=sekundy_pomiaru;
    rainfall_mm = 0;
    spd_wind_kmh_max = 0;

    // inicjalizacja timerów na potrzeby czujników
    //konfiguracja Timer1 16-bit licznik przybli¿onej sekundy do pomiarów kwarc 11.059.200 Hz
    TCCR1B |= (1<<WGM12);            // tryb CTC
    TCCR1B |= (1<<CS12)|(1<<CS10);    // prescaler = 1024
    OCR1A  = 10799;                // 1Hz tick (1s)
    TIMSK |= (1<<OCIE1A);            // przerwanie Compare




    // inicjalizacja przerwania INT0 na potrzeby zliczania impulsów z czujnika wiatru
    PORTD |= (1<<PD2) | (1<<PD3);            // podci¹gniêcie pinu INT0 do VCC
    MCUCR |= (1<<ISC01);            // wyzwalanie zboczem opadaj¹cym
    MCUCR |= (1<<ISC11);            // wyzwalanie zboczem opadaj¹cym
    GICR |= (1<<INT0);            // odblokowanie przerwania
    GICR |= (1<<INT1);            // odblokowanie przerwania

        // Przerwanie INT2
        PORTB |=(1<<PB2);       // pull up's na wejœciu INT2
        MCUCSR &=~(1<<ISC2);    // przerwanie na zboczu opadaj¹cym
        GICR |=(1<<INT2);       // w³¹czenie przerwania zewnêtrznego

    //ADC
    ADMUX |= (1<<REFS0);                                        // wybór wewnêtrznego Ÿród³a napiêcia odniesienia = 5V
    ADCSRA |= (1<<ADEN)|(1<<ADPS1)|(1<<ADPS0);                    // W³¹czenie modu³u ADC oraz ustawienie preskalera na 64
//    max_wind_E = 240;

}


//Obs³uga przerwania INT 0 pomiar prêdkoœci wiatru
ISR (INT0_vect)  {

//    PORTD &= ~(1<<PD7);
    tmp_spd_wind++;                // przy ka¿dym zboczu opadaj¹cym zlicz impuls

}

// Obs³uga przerwania INT 1 pomiar opadów
ISR( INT1_vect ) {



//    PORTD ^= (1<<PD6);
    tmp_imp_rainfall++;            // przy ka¿dym zboczu opadaj¹cym zlicz impuls
    opady_imp++;

}

// Obs³uga Timera
ISR(TIMER1_COMPA_vect)
{
//    PORTA ^= (1<<PA7); //dioda dla sprawdzenia poprawnoœci przerwania
//    lcd_cls();
kierunek_wiatru();
    predkosc_wiatru();


    if (tik==sekundy_pomiaru) {

    pomiar_opadu();
//    srednia_predkosc_wiatru();
    dominanta();
    tik=0;
    flaga_wyslij_dane = 1;

    }
tik++;
//wyswietl_LCD_opady();
//wyswietl_LCD_wiatr();
}
/*
 * main.c
 *
 *  Created on: 14 paŸ 2016
 *      Author: avrtech
 *      Strona www: http://avrtech.pl
 *
 *      Obs³uga czujników dla u¿ytku prywatnego wymaga pozostawienia stopki.
 *      Aby wykorzystaæ bibliotekê do celów komercyjnych proszê o kontakt poprzez stronê www.
 */


// DO£¥CZENIE STANDARDOWYCH BIBLIOTEK
#include <avr/io.h>
#include <avr/interrupt.h>
#include <util/delay.h>
#include <avr/pgmspace.h>
#include <inttypes.h>
#include <stdlib.h>
#include <stdio.h>
#include <string.h>
#include <avr/eeprom.h>
#include <avr/wdt.h>

#include "LCD/lcd44780.h"
#include "Meteo/meteo_sensors.h"
#include "MK_USART/mkuart.h"
#include "MK_TERMINAL/mk_term.h"
#include "1Wire/ds18x20.h"
#include "I2C_TWI/i2c_twi.h"
#include "DS3231/DS3231.h"

#define DEBUG1 (1<<PC2)
#define DEBUG1_ON PORTC |= DEBUG1    // makrodefinicja – za³¹czenie diody
#define DEBUG1_OFF PORTC &= ~DEBUG1    // makrodefinicja – wy³¹czenie diody
#define DEBUG1_TOG PORTC ^= DEBUG1    // makrodefinicja – zmiana stanu diody

#define DEBUG2 (1<<PC3)
#define DEBUG2_ON PORTC |= DEBUG2    // makrodefinicja – za³¹czenie diody
#define DEBUG2_OFF PORTC &= ~DEBUG2    // makrodefinicja – wy³¹czenie diody
#define DEBUG2_TOG PORTC ^= DEBUG2    // makrodefinicja – zmiana stanu diody


char uart_buf[100];    //bufor UART

void parse_rs232(char * buf);

int main(void){
    flaga_wyslij_dane =0;



    DDRC |= (1<<PC4);    // ustawiamy kierunek linii podœwietlenia LCD jako WYJŒCIE
    PORTC |= (1<<PC4);    // za³¹czamy podœwietlenie LCD - stan wysoki
    DDRA |= (1<<PA7);
    PORTA |= (1<<PA7);


    DDRC |= DEBUG1;    // Debug 1
//    PORTC |= DEBUG1;    //

    DDRC |= DEBUG2;    // Debug 2
//    PORTC |= DEBUG2;    //

    DDRD |= (1<<PD7);        // kierunek pinów PD6 i PD7 – wyjœciowy
    PORTD |= (1<<PD7);

    PORTB |= NLINK_PIN;

    init_sensors();

//    lcd_init();
//    lcd_locate(0,0);

//    UART
    USART_Init( __UBRR);
            register_uart_str_rx_event_callback(parse_rs232);
//
//    tr_cursor_hide(1);
//        tr_locate(1,0);
//        uart_puts ("Prêdkoœæ wiatru: ");
//        uart_putint(spd_wind_kmh_d, 10);
//        uart_puts (",");
//        uart_putint(spd_wind_kmh_j, 10);
//        uart_puts ("km/h");
//
        // Przerwanie INT2
        PORTB |=(1<<PB2);       // pull up's na wejœciu INT2
        MCUCSR &=~(1<<ISC2);    // przerwanie na zboczu opadaj¹cym
        GICR |=(1<<INT2);       // w³¹czenie przerwania zewnêtrznego



//            // Przerwanie INT2
//                    MCUCR |= (1<<ISC01)|(1<<ISC00); // zbocze narastaj¹ce
//                    PORTB |= (1<<PB2);        // podci¹gniêcie pinu INT2 do VCC
//
    //RTC DS3231


        i2cSetBitrate(100);
        DS3231_init();



//    lcd_str("Wiatr: ");
//
//        lcd_init();
//        lcd_locate(1,10);
//        lcd_str("K:           ");

    /* sprawdzamy ile czujników DS18xxx widocznych jest na magistrali */
        czujniki_cnt = search_sensors();

        /* wysy³amy rozkaz wykonania pomiaru temperatury
         * do wszystkich czujników na magistrali 1Wire
         * zak³adaj¹c, ¿e zasilane s¹ w trybie NORMAL,
         * gdyby by³ to tryb Parasite, nale¿a³oby u¿yæ
         * jako pierwszego prarametru DS18X20_POWER_PARASITE */
        DS18X20_start_meas( DS18X20_POWER_EXTERN, NULL );

        /* czekamy 750ms na dokonanie konwersji przez pod³¹czone czujniki */
            _delay_ms(750);

//    sekundy_pomiaru = 60;
     sekundy_pomiaru = 5;

 sei();                  // w³¹czenie przerwañ globalnych

    while(1){

//        DEBUG1_TOG;


        UART_RX_STR_EVENT(uart_buf);
           pomiar_temperatury ();

         if (   flaga_wyslij_dane == 1) {
//       wyslij_na_RS232();
//uart_puts ("wachcio");

//wyslij_dane_na_serwer (suma_imp_wiatr, poryw_wiatru_imp, dominanta_liczba, opady_imp, temperatura[1], temperatura[2]);

          }



//        wyslij_dane_na_serwer (suma_imp_wiatr, poryw_wiatru_imp, dominanta_liczba, opady_imp, temperatura[1], temperatura[2]);



    }
}

void parse_rs232(char * buf){

    if( !strncasecmp("AT+RST?", buf, 7) ) {
        cli();              // disable interrupts
        wdt_enable( 0 );      // set  watchdog
        while(1);           // wait for RESET
    }

    if( !strncasecmp("wachcio", buf, 7) ) {
        uart_puts ("ok-wachcio");
        }

      if( !strncasecmp("tog1", buf, 7) ) {
             DEBUG1_TOG;
        }

     if( !strncasecmp("tog2", buf, 7) ) {
             DEBUG2_TOG;
        }
}

ISR(INT2_vect) {

//            DEBUG2_TOG;
         DEBUG1_TOG;
//          uart_puts ("ok-wachcio");
//wyslij_na_RS232();
//            uart_putint(czujniki_cnt, 10);




}
# meteo_vue
System zbierania danych z kilkudziesięciu czujników. Zaczął powstawać w maju 2016 roku. Strona typu SPA powstaje od grudnia 2018 przy pomocy framework-a Vue.

Od jakiegoś czasu działał u mnie minikomputer Raspberry Pi z zainstalowanym Raspianem oraz systemem monitoringu temperatury (i nie tylko) Nettemp autorstwa techfreak. Mierzy on temperatury w kotłowni i na zewnątrz budynku za pomocą czujników DS18B20 oraz DHT22 (bardzo słabe i zawodne).

Po kilku miesiącach zacząłem myśleć nad własną stacją pogody która mogła by oprócz temperatur mierzyłć również inne parametry i co najważniejsze była mojego autorstwa. Dzięki pomocy ze strony forum Atnel oraz kanałowi YouTube Atnel - mirekk36 zaprojektowałem a następnie polutowałem urządzenie i zaprogramowałem w języku C mikrokontroler Atmega 32A który jest sercem stacji meteo. Stacja zbiera informacje z czujników: temperatury (DS18B20, BMP180, SHT21), wilgotności (SHT21), ciśnienia (BMP180), wiatru, opadów oraz nasłonecznienia (BH1750). 9 lutego 2020 zamieniłem czujnki SHT21 i BMP 180 na jeden BME280 który mierzy temperaturę, ciśnienie i wilgotność.

Zachęcony udaną budową stacji złożyłem projekt firmy Atnel opisany w żółtej książce Mirosława Kardasia czyli zegar w dwóch sztukach. Po modyfikacjach oprogramowania zegary znajdujące się w salonie oraz sypialni wysyłają dane do Raspberry Pi który zapisuje je w zewnętrznej bazie danych.

Kolejną małą częścią projektu stało się urządzenie oparte o znany moduł wi-fi ESP8266 do którego podłączyłem czujnik temperatury DS18B20 w hermetcznej obudowie i umieściłem w akwarium. On również wysyła swoje dane do Nettemp-a.

Ostatnim elementem układanki jest odpytywanie bazy danych Airly o dane z czujników jakości powietrza znajdującego się w mojej miejscowości (od maja 2021 dostępne są dwa czujniki).

Dane z wszystkich moich części systemu trafiają co minutę (dane jakości powietrza ze względu na ograniczenia AirlyAPI odczytywane są co kwadrans) do bazy danych MySQL umieszczonej na zewnętrznym serwerze. Odbywa się to za pośrednictwem napisanych przeze mnie skryptów PHP. Dopiero z tej bazy poprzez mój mini system Rest API czerpie informacje ta strona. Jeśli jest problem z danym czujnikiem i z jakiegoś powodu dane są starsze niż 5 minut (16 minut czujniki jakości powietrza) sygnalizowane to jest czerwoną obwódką wokół ikony czujnika. Po kliknięciu na czujnik pokazują się bardziej szczegółowe informacje. Natomist kliknięcie na tytuł kategorii powoduje jej ukrycie lub pokazanie.

##Demo
http://meteo.wachcio.pl/

## Project setup
```
npm install
```

### Compiles and hot-reloads for development
```
npm run serve
```

### Compiles and minifies for production
```
npm run build
```

### Run your tests
```
npm run test
```

### Lints and fixes files
```
npm run lint
```

### Customize configuration
See [Configuration Reference](https://cli.vuejs.org/config/).

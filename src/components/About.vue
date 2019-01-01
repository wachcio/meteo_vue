<template>
  <div class="wrapper">
    <h1>Garść informacji o projekcie</h1>
    <p></p>
    <p>System zbierania danych z kilkudziesięciu czujników. Zaczął powstawać w maju 2016 roku. Strona typu SPA powstaje od grudnia 2018 przy pomocy framework-a Vue.</p>
    <p>
      Od jakiegoś czasu działał u mnie minikomputer Raspberry Pi z zainstalowanym Raspianem oraz systemem monitoringu temperatury (i nie tylko)
      <a
        href="https://techfreak.pl/nettemp/"
        target="_blank"
      >Nettemp</a> autorstwa techfreak. Mierzy on temperatury w kotłowni i na zewnątrz budynku za pomocą czujników DS18B20 oraz DHT22 (bardzo słabe i zawodne).
    </p>
    <p>
      Po kilku miesiącach zacząłem myśleć nad własną stacją pogody która mogła by oprócz temperatur mierzyła by również inne parametry i co najważniejsze była mojego autorstwa. Dzięki pomocy ze strony forum
      <a
        href="https://forum.atnel.pl/portal.php"
        target="_blank"
      >Atnel</a> oraz kanałowi YouTube
      <a
        href="https://www.youtube.com/channel/UC9helAwUtau_y4qyTcSR4Tg"
        target="_blank"
      >Atnel - mirekk36</a> zaprojektowałem a następnie polutowałem urządzenie i zaprogramowałem w języku C mikrokontroler Atmega 32A który jest `sercem` stacji meteo. Stacja zbiera informacje z czujników: temperatury (DS18B20, BMP180, SHT21), wilgotności (SHT21), ciśnienia (BMP180), wiatru, opadów oraz nasłonecznienia (BH1750).
    </p>
    <p>
      Zachęcony udaną budową stacji złożyłem projekt firmy
      <a
        href="https://www.atnel.pl/"
        target="_blank"
      >Atnel</a> opisany w żółtej książce Mirosława Kardasia czyli zegar w dwóch sztukach. Po modyfikacjach oprogramowania zegary znajdujące się w salonie oraz sypialni wysyłają dane do Raspberry Pi który zapisuje je w zewnętrznej bazie danych.
    </p>
    <p>Kolejną małą częścią projektu stało się urządzenie oparte o znany moduł wi-fi ESP8266 do którego podłączyłem czujnik temperatury DS18B20 w hermetcznej obudowie i umieściłem w akwarium. On również wysyła swoje dane do Nettemp-a.</p>
    <p>Następnie pojawił się u mnie kolejny Raspberry Pi z oprogramowaniem jak ten pierwszy, który monitoruje temperatury w studni oraz garażu</p>
    <p>
      Ostatnim elementem `układanki` jest odpytywanie bazy danych
      <a
        href="https://airly.eu/pl/"
        target="_blank"
      >Airly</a> o dane z czujnika jakości powietrza znajdującego się w mojej miejscowości.
    </p>
    <p>Dane z wszystkich opisanych powyżej części systemu trafiają co minutę do bazy danych MySQL umieszczonej na zewnętrznym serwerze. Odbywa się to za pośrednictwem napisanych przeze mnie skryptów PHP. Dopiero z tej bazy poprzez mój mini system Rest API czerpie informacje ta strona. Jeśli jest problem z danym czujnikiem i z jakiegoś powodu dane są starsze niż 5 minut sygnalizowane to jest czerwoną obwódką wokół ikony czujnika. Po kliknięciu na czujnik pokazują się bardziej szczegółowe informacje. Natomist kliknięcie na tytuł kategorii powoduje jej ukrycie lub pokazanie.</p>
    <p>W zakładce `Odczyty archiwalne` można uzyskać podstawowe dane statystyczne (odczyt maksymalny, minimalny, średni i w niektórych wypadkach sumę) z czujników w danym przedziale czasowym: rok, miesiąc, dzień i godzina</p>
    <div class="sliderContainer">
      <div class="sliderWrapper">
        <vue-flux
          :options="fluxOptions"
          :images="fluxImages"
          :transitions="fluxTransitions"
          ref="slider"
        >
          <flux-controls slot="controls"></flux-controls>
          <flux-pagination slot="pagination"></flux-pagination>
        </vue-flux>
      </div>
    </div>
  </div>
</template>

<script>
import {
  VueFlux,
  FluxPagination,
  FluxControls,
  Transitions,
  FluxCaption
} from "vue-flux";
// import "vue-flux/dist/vue-flux.css";

export default {
  name: "About",
  data: () => ({
    fluxOptions: {
      autoplay: true,
      height: "auto"
    },
    fluxImages: [
      // "../assets/slider/meteo1.png",
      // "../assets/slider/meteo2.png",
      // "../assets/slider/meteo3.png",
      // "../assets/slider/meteo4.png",
      // "../assets/slider/IMG_5905.jpg",
      // "../assets/slider/IMG_5925.jpg"
      "http://wachcio.pl/meteo_vue/assets/slider/meteo1.png",
      "http://wachcio.pl/meteo_vue/assets/slider/meteo2.png",
      "http://wachcio.pl/meteo_vue/assets/slider/meteo3.png",
      "http://wachcio.pl/meteo_vue/assets/slider/meteo4.png",
      "http://wachcio.pl/meteo_vue/assets/slider/IMG_5905.jpg",
      "http://wachcio.pl/meteo_vue/assets/slider/IMG_5925.jpg"
    ],
    fluxCaptions: ["", "", "", "", "Widok czujników stacji meteo", ""],
    fluxTransitions: {
      transitionRound2: Transitions.transitionRound2
    }
  }),
  components: {
    VueFlux,
    FluxPagination,
    FluxControls,
    FluxCaption
  }
};
</script>

<style lang="scss" scoped>
.wrapper {
}
p {
  margin: 1.5em 1.5em;
  text-align: justify;
}
p + p {
  text-indent: 2em;
}

a {
  // text-decoration: none;
  color: #c7eafd;
}
.sliderContainer {
  display: flex;
  justify-content: center;
  width: 100vw;
  left: 0;
}

.sliderWrapper {
  width: 85%;
}
</style>

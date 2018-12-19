<template>
  <div id="main">
    <section v-if="sensorsCurrent.length>0" id="pageTitle">Stacja meteo Rypin</section>

    <div>
      <Nav
        :endpointCurrent="endpointCurrent"
        :isLoaded="isLoaded"
        :showInfo="showInfo"
        :activeSection="activeSection"
        @activeSectionFun="activeSectionFun"
        @showInfoFun="showInfoFun"
        @getCurrentJSON="getCurrentJSON"
      />
      <!-- <transition name="slide" mode="out-in" appear> -->
      <AnimateCSS enter="lightSpeedIn" leave="lightSpeedOut">
        <keep-alive>
          <component
            v-if="isLoaded"
            :is="activeSection"
            :sensorsCurrent="sensorsCurrent"
            :isLoaded="isLoaded"
            :showInfo="showInfo"
            :activeSection="activeSection"
            @activeSectionFun="activeSectionFun"
            @showInfoFun="showInfoFun"
          >
            <!-- <SensorCategory/>

            <ArchivesMain/>-->
            <router-view></router-view>
            <router-view></router-view>
          </component>
        </keep-alive>
      </AnimateCSS>
    </div>
    <Preloader v-if="!isLoaded"/>
    <footer>
      <hr>
      <div>Wachcio &copy; 2018</div>
    </footer>
  </div>
</template>

<script>
import axios from "axios";
import SensorCategory from "./components/Sensor/SensorCategory.vue";
import Nav from "./components/Nav/Nav.vue";
import Preloader from "./components/Preloader";
import ArchivesMain from "./components/Archives/ArchivesMain";
import AnimateCSS from "./components/CSS/AnimateCSS";

export default {
  name: "app",
  props: {
    endpointCurrent: String
  },
  data() {
    return {
      sensorsCurrent: [],
      isLoaded: false,
      showInfo: false,
      activeSection: "SensorCategory"
    };
  },
  components: {
    SensorCategory,
    Nav,
    Preloader,
    ArchivesMain,
    AnimateCSS
  },
  created() {
    // debugger;
    window.addEventListener("scroll", this.handleScroll);
    this.refreshData();
  },

  destroyed() {
    window.removeEventListener("scroll", this.handleScroll);
  },
  watch: {
    sensorsCurrent(newValue, oldValue) {
      // console.log(newValue);

      this.checkWindSpeed0();
    }
  },
  methods: {
    handleScroll(event) {
      this.showInfoFun(false);
    },
    getCurrentJSON() {
      axios
        .get(this.endpointCurrent)
        .then(res => (this.sensorsCurrent = res.data))
        .then((this.isLoaded = true));
    },
    refreshData() {
      this.getCurrentJSON();
      setTimeout(this.refreshData, 60000);
    },

    showInfoFun(visible) {
      this.showInfo = visible;
    },
    activeSectionFun(section) {
      this.activeSection = section;
    },
    checkWindSpeed0() {
      for (let sensor of this.sensorsCurrent) {
        if (sensor.sensorName == "Prędkość wiatru km/h") {
          if (sensor.valueCurrent.value == 0) {
            for (let sensor of this.sensorsCurrent) {
              if (sensor.sensorName == "Kierunek wiatru") {
                sensor.valueCurrent.value = "bezwietrznie";
                sensor.picture = "assets/strzalka_przezroczysta.png";
              }
            }
          }
        }
      }
    }
  }
};
</script>

<style lang="scss">
</style>

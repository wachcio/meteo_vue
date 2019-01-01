<template>
  <div id="main">
    <section id="pageTitle">Stacja meteo Rypin</section>

    <div>
      <Nav :endpointCurrent="endpointCurrent" :isLoaded="isLoaded" :showInfo="showInfo"/>

      <AnimateCSS enter="lightSpeedIn" leave="lightSpeedOut">
        <keep-alive>
          <router-view></router-view>
        </keep-alive>
      </AnimateCSS>
    </div>
    <Preloader/>
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
import { mapState, mapMutations, mapActions, mapGetters } from "vuex";

export default {
  name: "app",
  props: {
    endpointCurrent: String
  },
  data() {
    return {};
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
    // console.log("test");

    window.addEventListener("scroll", this.handleScroll);
    this.refreshData();
    this.timer();
  },
  destroyed() {
    window.removeEventListener("scroll", this.handleScroll);
  },
  watch: {
    // sensorsCurrent(newValue, oldValue) {
    //   this.checkWindSpeed0();
    // }
  },
  computed: {
    ...mapState(["sensorsCurrent", "isLoaded", "showInfo"])
  },
  getters: {
    ...mapGetters(["winDirectionIndex"])
  },
  methods: {
    ...mapMutations(["updateSensorsCurrent"]),
    ...mapActions(["getCurrentJSON"]),
    handleScroll(event) {
      if (this.showInfo) {
        this.$store.commit("showInfo", false);
      }
    },
    timer() {
      // this.$store.commit("timer", new Date());
      // setTimeout(this.timer, 1000);
    },

    refreshData() {
      this.$store.dispatch("getCurrentJSON");
      setTimeout(this.refreshData, 60000);
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

<template>
  <div id="main">
    <section id="pageTitle">Stacja meteo Rypin</section>
    <div v-if="isLoaded">
      <Nav
        :endpointCurrent="endpointCurrent"
        :isLoaded="isLoaded"
        :showInfo="showInfo"
        :activeSection="activeSection"
        @activeSectionFun="activeSectionFun"
        @showInfoFun="showInfoFun"
        @getCurrentJSON="getCurrentJSON"
      />

      <SensorCategory
        :sensorsCurrent="sensorsCurrent"
        :isLoaded="isLoaded"
        :showInfo="showInfo"
        :activeSection="activeSection"
        @activeSectionFun="activeSectionFun"
        @showInfoFun="showInfoFun"
      />
      <AirQualityWidget v-if="activeSection=='current'"/>
      <div v-show="activeSection=='archives'">
        <ArchivesMain/>
      </div>
    </div>
    <Preloader v-if="!isLoaded"/>
  </div>
</template>

<script>
import axios from "axios";
import SensorCategory from "./components/Sensor/SensorCategory.vue";
import Nav from "./components/Nav/Nav.vue";
import AirQualityWidget from "./components/Sensor/AirQualityWidget";
import Preloader from "./components/Preloader";
import ArchivesMain from "./components/Archives/ArchivesMain";

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
      activeSection: "current"
    };
  },
  components: {
    SensorCategory,
    Nav,
    AirQualityWidget,
    Preloader,
    ArchivesMain
  },
  created() {
    // debugger;
    window.addEventListener("scroll", this.handleScroll);
    this.refreshData();
  },

  destroyed() {
    window.removeEventListener("scroll", this.handleScroll);
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
    }
  }
};
</script>

<style type="scss">
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  display: flex;
  flex-basis: 100%;
  background-color: #0369ba;
  color: #c7eafd;
  font-family: "Lato", sans-serif;
  font-size: 19px;
  font-style: italic;
  scrollbar-3dlight-color: #e3edef;
  scrollbar-arrow-color: #c7eafd;
  scrollbar-darkshadow-color: #0369ba;
  scrollbar-face-color: #0369ba;
  scrollbar-highlight-color: #c7eafd;
  scrollbar-shadow-color: #c7eafd;
  scrollbar-track-color: #0369ba;
  text-shadow: 4px 4px 11px black;
  scrollbar-base-color: #c7eafd;
}
#main {
  width: 100vw;
}
h1 {
  text-align: center;
  font-size: 30px;
  margin-top: 25px;
  margin-bottom: 40px;
  letter-spacing: 3px;
}

main {
  margin-left: auto;
  margin-right: auto;
  min-width: 400px;
  position: relative;
  overflow: hidden;
}

#pageTitle {
  display: block;
  left: 0;
  margin-top: 20px;
  min-width: 400px;
  margin: 0 auto;
  text-align: center;
  font-size: 60px;
  font-style: oblique;
  padding-top: 55px;
}
p {
  font-size: 15pt;
  margin-top: 5px;
}

hr,
.hr2,
.hr3 {
  color: #68bafb;
  width: 70%;
  background: #68bafb;
  height: 1px;
  border: 0px;
  margin-top: 1px;
  margin-bottom: 0;
  padding: 0;
}

.hr1 {
  width: 60%;
}

.hr2 {
  width: 65%;
}
</style>

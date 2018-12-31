<template>
  <div class="readings" v-show="isLoaded || sensorsCurrent.length">
    <div class="wrapper">
      <div class="sensorTitle" v-for="n in 4" :key="n">
        <div class="hrWrapper" v-if="n>1">
          <hr class="hr1">
          <hr class="hr2">
          <hr>
        </div>
        <h1
          class="categoryTitle"
          @click="categoryClick(n-1)"
        >{{h1Title(sensorsCurrent[newCategoryIndex[n-1]])}}</h1>

        <AnimateCSS enter="lightSpeedIn" leave="lightSpeedOut">
          <div class="sensorWrapper" v-if="categoryVisible[n-1]">
            <div v-for="(sensorCurrent, i) in sensorsToCategory(n)" :key="i">
              <Sensor :sensorCurrent="sensorCurrent"/>
            </div>
            <AirQualityWidget v-if="n==4"/>
          </div>
        </AnimateCSS>
      </div>
    </div>

    <Transition name="fade">
      <InfoBox v-if="showInfo"/>
    </Transition>
  </div>
</template>

<script>
import Vue from "vue";
import Sensor from "./Sensor";
import InfoBox from "./InfoBox";

import AirQualityWidget from "./AirQualityWidget";
import AnimateCSS from "../CSS/AnimateCSS";
import { mapState, mapMutations, mapActions, mapGetters } from "vuex";

export default {
  name: "SensorCategory",
  props: {},
  data() {
    return {
      newCategoryIndex: [0, 16, 30, 34],
      currentDate: undefined,
      categoryVisible: [true, true, true, true],
      sensorData: undefined
    };
  },
  methods: {
    ...mapMutations(["updateSensorsCurrent"]),
    ...mapActions(["getCurrentJSON"]),

    sensorsToCategory: function(categoryNr) {
      return this.sensorsCurrent.filter(function(sensor) {
        return sensor.sensorCategoryNr == categoryNr;
      });
    },

    sensorActiveData(data) {
      this.sensorData = data;
    },
    h1Title(data) {
      // console.log(data);
      if (data !== undefined) {
        // console.log("Title " + data.sensorCategoryTitle);
        // console.log(data);
        return data.sensorCategoryTitle;
      } else {
        return null;
      }
    },
    categoryClick(categoryIndex) {
      this.categoryVisible.splice(
        categoryIndex,
        1,
        !this.categoryVisible[categoryIndex]
      );
    }
  },
  computed: {
    ...mapState(["sensorsCurrent", "isLoaded", "showInfo", "sensorActive"])
    // sensorsCurrent() {
    //   return this.$store.state.sensorsCurrent;
    // },
    // showInfo() {
    //   return this.$store.state.showInfo;
    // }
  },
  components: {
    Sensor,
    InfoBox,
    AirQualityWidget,
    AnimateCSS
  },
  watch: {
    // categoryVisible() {
    //   this.$forceUpdate();
    // }
  },

  created() {
    // this.currentDate = new Date();
    // this.timer();
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.wrapper {
  position: relative;
  left: 0;
  top: 0;
  margin-top: 15px;
  margin-bottom: 15px;
  text-align: center;
  display: flex;
  flex-basis: 100%;
  flex-wrap: wrap;
  justify-content: center;
  transition: left 0.3s;
}
.sensorTitle {
  flex-basis: 100%;
  flex-grow: 1;
  /* display: flex; */
  /* flex-direction: column; */
  /* justify-content: center; */
  text-align: center;
}
.readings,
.sensorWrapper {
  /* display: none; */
  flex-basis: 100%;
  display: flex;
  flex-wrap: wrap;

  justify-content: center;
}
hr,
.hr2,
.hr3 {
  position: relative;
  left: 50%;
  transform: translateX(-50%);
  color: #68bafb;
  width: 70%;
  background: #68bafb;
  height: 1px;
  border: 0px;
  margin-top: 1px;
  margin-bottom: 0;
  padding: 0;
  text-align: center;
}

.hr1 {
  width: 60%;
}

.hr2 {
  width: 65%;
}
.hrWrapper {
  position: relative;
  text-align: center;
}
.hideShowSection-enter-active,
.hideShowSection-leave-active {
  transition: all 0.4s ease-in-out;
}
.hideShowSection-enter {
  transform: translateX(-100vw);
  opacity: 1;
}

.hideShowSection-leave-to {
  transform: translateX(100vw);
  opacity: 0;
}
.categoryTitle {
  cursor: pointer;
}
</style>

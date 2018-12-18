<template>
  <div class="readings" v-if="sensorsCurrent.length>0">
    <div class="wrapper">
      <div class="sensorTitle" v-for="n in 4" :key="n">
        <div class="hrWrapper" v-if="n>1">
          <hr class="hr1">
          <hr class="hr2">
          <hr>
        </div>
        <h1
          @click="categoryVisible[n-1]=!categoryVisible[n-1]"
        >{{h1Title(sensorsCurrent[newCategoryIndex[n-1]])}}</h1>
        <transition name="hideShowSection">
          <div class="sensorWrapper" v-if="categoryVisible[n-1]">
            <div v-for="(sensorCurrent, i) in sensorsToCategory(n)" :key="i">
              <Sensor
                :sensorCurrent="sensorCurrent"
                :showInfo="showInfo"
                :currentDate="currentDate"
                @timer="timer"
                @showInfoFun="showInfoFun"
                @sensorActiveData="sensorActiveData"
              />
            </div>
          </div>
        </transition>
      </div>
    </div>
    <AirQualityWidget/>
    <Transition name="fade">
      <InfoBox
        :sensorData="sensorData"
        :isLoaded="isLoaded"
        :showInfo="showInfo"
        v-if="showInfo"
        @showInfoFun="showInfoFun"
      />
    </Transition>
  </div>
</template>

<script>
import Sensor from "./Sensor";
import InfoBox from "./InfoBox";

import AirQualityWidget from "./AirQualityWidget";

export default {
  name: "SensorCategory",
  props: {
    sensorsCurrent: Array,
    isLoaded: Boolean,
    showInfo: Boolean
  },
  data() {
    return {
      newCategoryIndex: [0, 16, 30, 34],
      currentDate: undefined,
      categoryVisible: [true, true, true, true, true]
    };
  },
  methods: {
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
    showInfoFun(visible) {
      this.$emit("showInfoFun", visible);
    },
    timer() {
      this.currentDate = new Date();
      setTimeout(this.timer, 1000);
    }
  },
  components: {
    Sensor,
    InfoBox,
    AirQualityWidget
  },
  watch: {
    // sensorsCurrent
  },

  created() {
    this.currentDate = new Date();
    this.timer();
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style type="scss" scoped>
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
</style>

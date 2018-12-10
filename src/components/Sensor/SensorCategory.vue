<template>
  <div class="readings">
    <div class="wrapper">
      <div class="sensorTitle" v-for="n in 4">
        <div class="hrWrapper" v-if="n>1">
          <hr class="hr1">
          <hr class="hr2">
          <hr>
        </div>
        <h1>{{sensorsCurrent[newCategoryIndex[n-1]].sensorCategoryTitle}}</h1>
        <div class="sensorWrapper">
          <div v-for="(sensorCurrent, i) in sensorsToCategory(n)" :key="i">
            <Sensor :sensorCurrent="sensorCurrent"/>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Sensor from "./Sensor";

export default {
  name: "SensorCategory",
  props: {
    sensorsCurrent: Array
  },
  data() {
    return {
      newCategoryIndex: [0, 16, 30, 34]
    };
  },
  methods: {
    sensorsToCategory: function(categoryNr) {
      return this.sensorsCurrent.filter(function(sensor) {
        return sensor.sensorCategoryNr == categoryNr;
      });
    }
  },
  components: {
    Sensor
  },
  watch: {
    // sensorsCurrent
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
</style>

<template>
  <div>
    <div class="value" :class="sensorCurrent.sensorName == 'Kierunek wiatru' ? 'center' : null">
      <img
        v-if="sensorCurrent.sensorName !== 'Kierunek wiatru'"
        v-bind:src="'./assets/strzalka_przezroczysta.png'"
      >
      <div :class="checkAlarms">{{sensorValue(sensorCurrent, 1)}}</div>
    </div>
    <div class="value">
      <img
        v-if="sensorCurrent.sensorName !== 'Kierunek wiatru'"
        v-bind:src="'./assets/strzalka_czerwona.png'"
      >
      {{sensorValue(sensorCurrent, 2)}}
    </div>
    <div class="value">
      <img
        v-if="sensorCurrent.sensorName !== 'Kierunek wiatru'"
        v-bind:src="'./assets/strzalka_niebieska.png'"
      >
      {{sensorValue(sensorCurrent, 3)}}
    </div>
  </div>
</template>

<script>
export default {
  name: "SensorValues",
  props: {
    sensorCurrent: Object
  },
  methods: {
    sensorValue(sensor, unitNr) {
      let unit = "";

      if (sensor.sensorName !== "Opady") {
        switch (unitNr) {
          case 1:
            return sensor.valueCurrent.value + " " + sensor.unit;
          // break;

          case 2:
            return sensor.valueMax.value + " " + sensor.unit;
          // break;

          case 3:
            return sensor.valueMin.value + " " + sensor.unit;
          // break;
        }
      } else {
        switch (unitNr) {
          case 1:
            unit = sensor.valueCurrent.value + " " + "mm/min";
            break;

          case 2:
            unit = sensor.valueMax.value + " " + "mm/h";
            break;

          case 3:
            unit = sensor.valueMin.value + " " + "mm/d";
            break;
        }

        return unit;
      }
    }
  },
  computed: {
    checkAlarms() {
      if (this.sensorCurrent.alarmMax) {
        return "alarmMax";
      } else if (this.sensorCurrent.alarmMin) {
        return "alarmMin";
      } else {
        return "";
      }
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
@import "../../css/_common";
.value {
  text-align: right;
  font-style: oblique;
  margin-top: 3px;
  // margin-right: 5px;
  padding-right: 7px;
  color: $textColor;
}
.value > img {
  margin-bottom: -8px;
  margin-right: 1px;
  float: left;
  margin-left: 1px;
  width: 29px;
  height: 29px;
  border: 0;
}

.center {
  text-align: center;
}

@mixin alarm($color) {
  border: 0 solid $color;
  border-radius: 7px;
  background-color: $color;
  padding-right: 7px;
  text-align: center;
}

.alarmMax {
  @include alarm(red);
}

.alarmMin {
  @include alarm(rgb(0, 4, 248));
}
</style>

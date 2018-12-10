<template>
  <div>
    <div class="sensor" @click="clickSensor">
      <SensorTitle :sensorCurrent="sensorCurrent"/>
      <SensorIcon :sensorCurrent="sensorCurrent"/>
      <SensorValues :sensorCurrent="sensorCurrent"/>
    </div>
  </div>
</template>

<script>
import SensorTitle from "./SensorTitle";
import SensorIcon from "./SensorIcon";
import SensorValues from "./SensorValues";

export default {
  name: "Sensor",
  props: {
    sensorCurrent: Object
  },
  data() {
    return {};
  },
  components: {
    SensorTitle,
    SensorIcon,
    SensorValues
  },
  watch: {
    // sensorsCurrent
  },
  methods: {
    clickSensor() {
      this.$emit("isVisibleInfo", true);

      this.$emit("sensorActiveData", this.sensorCurrent);
    }
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
  flex-wrap: wrap;
  justify-content: center;
  transition: left 0.3s;
}
.sensor {
  margin: 10px;
  height: 320px;
  float: left;
  width: 147px;
}

.error {
  border: 0 solid red;
  border-radius: 18px;
  box-shadow: 0 0 10px 8px red;
}

.center {
  text-align: center;
}
</style>

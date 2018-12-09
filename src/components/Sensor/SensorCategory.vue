<template>
  <div class="wrapper">
    <Sensor :sensorsCurrent="sensorsCurrent"/>
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
    return {};
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
  flex-wrap: wrap;
  justify-content: center;
  transition: left 0.3s;
}
</style>

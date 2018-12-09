<template>
  <div>
    <div class="value" v-text="sensorCurrent.valueCurrent.value + ' ' + sensorCurrent.unit"></div>
    <div class="value" v-text="sensorCurrent.valueMax.value + ' ' + sensorCurrent.unit"></div>
    <div class="value" v-text="sensorCurrent.valueMin.value + ' ' + sensorCurrent.unit"></div>
  </div>
</template>

<script>
export default {
  name: "SensorValues",
  props: {
    sensorCurrent: Object
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style type="scss"scoped>
.value {
  text-align: right;
  font-style: oblique;
  margin-top: 3px;
  /*    width: 130px;*/
  padding-right: 7px;
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
</style>

<template>
  <div class="title" @click="showInfo">{{sensorCurrent.sensorName}}</div>
</template>

<script>
export default {
  name: "SensorTitle",
  props: {
    sensorCurrent: Object
  },
  data() {
    return {
      // sensorsCurrent
    };
  },
  methods: {
    showInfo() {
      console.log("Klik w tytuł");
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style type="scss" scoped>
.title {
  text-align: center;
  margin-bottom: 15px;
  height: 50px;
}
</style>

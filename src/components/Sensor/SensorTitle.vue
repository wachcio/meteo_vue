<template>
  <div class="title">{{sensorCurrent.sensorName}}</div>
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
  methods: {}
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.title {
  text-align: center;
  margin-bottom: 15px;
  height: 50px;
}
</style>

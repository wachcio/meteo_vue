<template>
  <div>
    <iframe
      :id="airly_305987675"
      :src="'https://airly.eu/map/widget.html#lat=53.06277&lng=19.41194&id=2944&w=314&h=266&l=pl&m=true&i=true&ah=true&aw=true'"
    ></iframe>
  </div>
</template>
 <script src="https://airly.eu/map/airly.js" type="text/javascript"></script>
<script>
export default {
  name: "AirQualityWidget",
  props: {},
  data() {
    return {};
  },
  components: {},
  watch: {
    // sensorsCurrent
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
div {
  text-align: center;
}
iframe {
  max-width: 1200px;
  width: 90vw;
  border: none;
  margin-bottom: 20px;
  /* height: 180px; */
}
</style>

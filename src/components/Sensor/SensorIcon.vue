<template>
  <div class="icon" :class="sensorCurrent.sensorName == 'Kierunek wiatru' ? 'windDirection' : null">
    <img v-bind:src="windIconCorrection(sensorCurrent)">
    <!-- <img v-bind:src="'./assets/' +sensorCurrent.picture"> -->
  </div>
</template>

<script>
export default {
  name: "SensorIcon",
  props: {
    sensorCurrent: Object
  },
  methods: {
    windIconCorrection(sensor) {
      let picture = "";

      if (sensor.sensorName === "Kierunek wiatru") {
        // picture = "./" + sensor.picture; //dla serwera produkcyjnego
        picture = "http://wachcio.pl/meteo_vue/" + sensor.picture; //dla serwera lokalnego
      } else {
        picture = "./assets/" + sensor.picture;
      }
      return picture;
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.icon {
  width: 137px;
  height: 137px;
  /* border: 15px solid red; */
}
.icon > img {
  left: 0;
  top: 0;
  /* transform: translate(-50%, -50%); */
  width: 137px;
  height: 137px;
  border: 0;
  margin: 0;
  padding: 0;
  border-radius: 15px;
}

.windDirection {
  /* background-image: url("../img/kafelek.png"); */
  background-image: url("../../assets/kafelek.png");
  background-repeat: no-repeat;
  width: 137px;
  height: 137px;
}
.windDirection > img {
  position: relative;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
}
</style>

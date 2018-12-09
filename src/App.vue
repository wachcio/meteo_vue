<template>
  <div id="main">
    <section id="pageTitle">Stacja meteo Rypin</section>
    <Nav/>
    <Sensor :sensorsCurrent="sensorsCurrent"/>
  </div>
</template>

<script>
import axios from "axios";
import Sensor from "./components/Sensor/Sensor.vue";
import Nav from "./components/Nav/Nav.vue";

export default {
  name: "app",
  props: {
    endpointCurrent: String
  },
  data() {
    return {
      sensorsCurrent: []
    };
  },
  components: {
    Sensor,
    Nav
  },
  created() {
    axios
      .get(this.endpointCurrent)
      .then(res => (this.sensorsCurrent = res.data));
  }
};
</script>

<style type="scss">
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  background-color: #0369ba;
  color: #c7eafd;
  font-family: "Lato", sans-serif;
  font-size: 20px;
  font-style: italic;
  scrollbar-3dlight-color: #e3edef;
  scrollbar-arrow-color: #c7eafd;
  scrollbar-darkshadow-color: #0369ba;
  scrollbar-face-color: #0369ba;
  scrollbar-highlight-color: #c7eafd;
  scrollbar-shadow-color: #c7eafd;
  scrollbar-track-color: #0369ba;
  text-shadow: 4px 4px 11px black;
  scrollbar-base-color: #c7eafd;
}
h1 {
  text-align: center;
  font-size: 30px;
  margin-top: 25px;
  margin-bottom: 40px;
  letter-spacing: 3px;
}

main {
  margin-left: auto;
  margin-right: auto;
  min-width: 400px;
  position: relative;
  overflow: hidden;
}

#pageTitle {
  display: block;
  left: 0;
  margin-top: 20px;
  min-width: 400px;
  margin: 0 auto;
  text-align: center;
  font-size: 60px;
  font-style: oblique;
  padding-top: 55px;
}
p {
  font-size: 15pt;
  margin-top: 5px;
}

hr,
.hr2,
.hr3 {
  color: #68bafb;
  width: 70%;
  background: #68bafb;
  height: 1px;
  border: 0px;
  margin-top: 1px;
  margin-bottom: 0;
  padding: 0;
}

.hr1 {
  width: 60%;
}

.hr2 {
  width: 65%;
}
</style>

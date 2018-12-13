<template>
  <nav>
    <div class="container">{{sensorsNames}}</div>
  </nav>
</template>

<script>
import axios from "axios";

export default {
  name: "ArchivesName",
  props: {},
  data() {
    return {
      sensorsNames: [],
      endpointNames:
        "http://wachcio.pl/meteo_test/API/GetJSON.php?getSensorName=all"
    };
  },
  methods: {},
  created() {
    axios.get(this.endpointNames).then(res => (this.sensorsNames = res.data));
  }
};
</script>

<style type="scss">
</style>

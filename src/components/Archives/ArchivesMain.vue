<template>
  <div class="container" v-if="isLoaded">
    <h1>Archiwum odczytów</h1>
    <ArchivesForm :sensorsNames="sensorsNames"/>
  </div>
</template>

<script>
import axios from "axios";
import ArchivesForm from "./ArchivesForm";
import { mapState, mapMutations, mapActions, mapGetters } from "vuex";

export default {
  name: "ArchivesMain",
  props: {},
  components: {
    ArchivesForm
  },
  data() {
    return {
      sensorsNames: [],
      endpointNames:
        "http://wachcio.pl/meteo_test/API/GetJSON.php?getSensorName=all",
      isLoaded: false
    };
  },
  computed: {
    ...mapState(["sensorsCurrent", "isLoaded", "showInfo", "sensorActive"])
  },
  methods: {
    ...mapMutations(["updateSensorsCurrent"]),
    ...mapActions(["getCurrentJSON"])
  },
  created() {
    if (this.sensorsNames.length == 0) {
      axios
        .get(this.endpointNames)
        .then(res => (this.sensorsNames = res.data))
        .then((this.isLoaded = true));
    }
  }
};
</script>

<style lang="scss">
.container {
  display: flex;
  flex-direction: column;
}
</style>

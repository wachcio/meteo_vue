<template>
  <div class="container">
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
        "http://wachcio.pl/meteo_test/API/GetJSON.php?getSensorName=all"
    };
  },
  computed: {
    ...mapState(["sensorsCurrent", "isLoaded", "showInfo", "sensorActive"])
  },
  methods: {
    ...mapMutations(["updateSensorsCurrent", "isLoadedChange"]),
    ...mapActions(["getCurrentJSON"])
  },
  created() {
    if (this.sensorsNames.length == 0) {
      axios
        .get(this.endpointNames)
        .then(res => (this.sensorsNames = res.data))
        .then(this.$store.commit("isLoadedChange", true));
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

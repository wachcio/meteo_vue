<template>
  <div>
    <h1>{{title}}</h1>
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions, mapGetters } from "vuex";

export default {
  name: "About",
  props: {},
  components: {},
  data() {
    return {};
  },
  methods: {
    ...mapMutations(["updateSensorsCurrent"]),
    ...mapActions(["getCurrentJSON"])
  },
  computed: {
    ...mapState([
      "sensorsCurrent",
      "isLoaded",
      "showInfo",
      "sensorActive",
      "endpoints"
    ]),
    title() {
      // return this.endpoints.endpointCurrent;
      return "Dawno, dawno temu...";
    }
  },
  created() {}
};
</script>

<style lang="scss">
</style>

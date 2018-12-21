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
    ...mapState(["sensorsCurrent", "isLoaded", "showInfo", "sensorActive"]),
    title() {
      return this.$store.state.endpoints.endpointCurrent;
    }
  },
  created() {}
};
</script>

<style lang="scss">
</style>

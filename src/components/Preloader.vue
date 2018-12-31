<template>
  <div id="preloader" v-if="!isLoaded && !sensorsCurrent.length">
    <img src="../assets/preloader.png">
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions, mapGetters } from "vuex";
export default {
  name: "Sensor",
  props: {},
  data() {
    return {};
  },
  components: {},
  computed: {
    ...mapState(["sensorsCurrent", "isLoaded", "showInfo", "sensorActive"])
  },
  watch: {},
  methods: {}
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
#preloader {
  position: fixed;
  height: 128px;
  width: 128px;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
  z-index: 100;
}
</style>

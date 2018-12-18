<template>
  <div id="preloader">
    <img src="/assets/preloader.png">
  </div>
</template>

<script>
export default {
  name: "Sensor",
  props: {
    isLoaded: Boolean
  },
  data() {
    return {};
  },
  components: {},
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

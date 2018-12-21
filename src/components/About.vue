<template>
  <div>
    <h1>{{title}}</h1>
  </div>
</template>

<script>
export default {
  name: "About",
  props: {},
  components: {},
  data() {
    return {};
  },
  methods: {},
  computed: {
    title() {
      return this.$store.state.endpoints.endpointCurrent;
    }
  },
  created() {}
};
</script>

<style lang="scss">
</style>

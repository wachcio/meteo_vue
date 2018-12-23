<template>
  <nav>
    <div class="container">
      <div class="item refresh" @click="getCurrentJSON()">Odśwież dane</div>
      <router-link
        to="/current"
        tag="div"
        class="item current"
        active-class="active"
        exact
      >Odczyty aktualne</router-link>
      <router-link
        to="/archive"
        tag="div"
        class="item archive"
        active-class="active"
      >Odczyty archiwalne</router-link>
      <router-link to="about" tag="div" class="item about" active-class="active">O projekcie</router-link>
    </div>
  </nav>
</template>

<script>
import axios from "axios";
import { mapState, mapMutations, mapActions, mapGetters } from "vuex";

export default {
  name: "Nav",
  props: {},
  computed: {
    ...mapState(["sensorsCurrent", "isLoaded", "showInfo"])
  },
  methods: {
    ...mapMutations(["updateSensorsCurrent"]),
    ...mapActions(["getCurrentJSON"])
  }
};
</script>

<style lang="scss" scoped>
nav {
  display: flex;
  justify-content: center;
  position: relative;
  left: 0;
  top: 0;
  width: 100%;
  margin-top: 17px;
}

.container {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
}

.item {
  width: 200px;
  background-color: #01335c;
  color: #c7eafd;
  padding: 15px 10px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin: 5px 20px;
  text-align: center;
}

.item:hover,
a {
  text-decoration: none;
}
.active {
  background-color: #68bafb;
}

@media screen and (max-width: 1100px) {
  button {
    position: relative;
  }

  .container {
    flex-direction: column;
  }

  #archiveForm {
    flex-direction: column;
  }
}
</style>

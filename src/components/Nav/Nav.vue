<template>
  <nav>
    <div class="container">
      <div class="item refresh" @click="getJSON">Odśwież dane</div>
      <router-link to="/current">
        <div
          class="item current"
          :class="checkActive('SensorCategory')"
          @click="changeSection('SensorCategory')"
        >Odczyty aktualne</div>
      </router-link>
      <router-link to="archive">
        <div
          class="item archive"
          :class="checkActive('ArchivesMain')"
          @click="changeSection('ArchivesMain')"
        >Odczyty archiwalne</div>
      </router-link>
    </div>
  </nav>
</template>

<script>
import axios from "axios";

export default {
  name: "Nav",
  props: {
    endpointCurrent: String,
    showInfo: Boolean,
    activeSection: String
  },
  methods: {
    getJSON() {
      this.$emit("showInfoFun", false);
      this.$emit("getCurrentJSON");
    },
    hideInfo() {
      this.$emit("showInfoFun", false);
    },
    changeSection(section) {
      if (section == "SensorCategory") {
        this.getJSON();
      }
      this.$emit("activeSectionFun", section);
    },
    checkActive(section) {
      if (section == this.activeSection) {
        this.$emit("activeSectionFun", section);
        return { active: true };
      } else {
        return null;
      }
    }
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
.active {
  background-color: #68bafb;
}
a {
  text-decoration: none;
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

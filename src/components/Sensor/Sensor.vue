<template>
  <div>
    <div class="sensor" :title="sesnorHint" @click.prevent="clickSensor">
      <SensorTitle :sensorCurrent="sensorCurrent"/>
      <SensorIcon :class="checkDate" :sensorCurrent="sensorCurrent"/>
      <SensorValues :sensorCurrent="sensorCurrent"/>
    </div>
  </div>
</template>

<script>
import SensorTitle from "./SensorTitle";
import SensorIcon from "./SensorIcon";
import SensorValues from "./SensorValues";
import { DateTime } from "luxon";

export default {
  name: "Sensor",
  props: {
    sensorCurrent: Object,
    showInfo: Boolean,
    currentDate: Date
  },
  data() {
    return {
      upToDate: true,
      sesnorHint: ""
    };
  },
  components: {
    SensorTitle,
    SensorIcon,
    SensorValues
  },
  methods: {
    clickSensor() {
      this.$emit("showInfoFun", true);

      this.$emit("sensorActiveData", this.sensorCurrent);
    },
    diffDate(sensorDate) {
      let i1 = DateTime.fromSQL(sensorDate),
        i2 = DateTime.local(),
        // i2 = this.currentDate,
        diff = i2.diff(i1, ["days", "hours", "minutes", "seconds"]).toObject(),
        result = "";

      if (diff.days) {
        result += diff.days + " dni, ";
      }

      if (diff.hours) {
        result += diff.hours + " godzin/y, ";
      }

      if (diff.minutes) {
        result += diff.minutes + " minut/y, ";
      }

      if (diff.seconds) {
        result += Math.floor(diff.seconds) + " sekund";
      }

      return result;
    },
    hint() {
      this.sesnorHint =
        "Ostatni odczyt " +
        this.sensorCurrent.valueCurrent.value +
        this.sensorCurrent.unit +
        " (" +
        this.diffDate(this.sensorCurrent.valueCurrent.date) +
        " temu)";

      // setTimeout(this.hint, 1000);
    },
    checkDate() {
      let dtSensor = new Date(this.sensorCurrent.valueCurrent.date),
        diff = Math.floor((this.currentDate - dtSensor) / 60000);
      // console.log(diff);

      if (diff > 4) {
        return {
          error: true
        };
      } else {
        return {};
      }
    }
  },
  computed: {},
  watch: {
    currentDate(newValue, OldValue) {}
  },
  mounted() {
    this.hint();
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style type="scss" scoped>
.wrapper {
  position: relative;
  left: 0;
  top: 0;
  margin-top: 15px;
  margin-bottom: 15px;
  text-align: center;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  transition: left 0.3s;
}
.sensor {
  margin: 10px;
  height: 320px;
  float: left;
  width: 137px;
}

.error {
  border: 0 solid red;
  border-radius: 15px;
  box-shadow: 0 0 8px 8px red;
}

.center {
  text-align: center;
}
</style>

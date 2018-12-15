<template>
  <div class="wrapper">
    <div class="archiveFormContainer">
      <label for="archiveForm">Wybierz datę lub okres dla którego zostaną wyświetlone statystyki</label>
      <form id="archiveForm">
        <label for="sensor">Czujnik</label>
        <select name="sensor" id="sensor" v-model="sensorIndex">
          <option v-for="(sensor, index) in sensorsNames" :value="index" :key="index">{{sensor}}</option>
        </select>
        <div>
          <label for="year">Rok</label>
          <input type="number" name="year" id="year" min="2016" max="2030" v-model="year">
        </div>
        <div class="checkboxGroup">
          <input type="checkbox" name="useMonth" id="useMonth" v-model="useMonth">
          <label for="useMonth">miesiąc</label>
          <input
            type="number"
            name="month"
            id="month"
            min="1"
            max="12"
            v-model="month"
            :disabled="!useMonth"
          >
        </div>
        <div class="checkboxGroup">
          <input type="checkbox" id="useDay" v-model="useDay" :disabled="!useMonth">
          <label for="useDay">dzień</label>
          <input
            type="number"
            name="day"
            id="day"
            min="1"
            max="31"
            v-model="day"
            :disabled="!useMonth || !useDay"
          >
        </div>
        <div class="checkboxGroup">
          <input type="checkbox" id="useHour" v-model="useHour" :disabled="!useMonth || !useDay">
          <label for="useHour">godzina</label>
          <input
            type="number"
            name="hour"
            id="hour"
            min="0"
            max="23"
            v-model="hour"
            :disabled="!useMonth || !useDay || !useHour"
          >
        </div>
        <input
          type="submit"
          id="archiveShowResult"
          value="Wyświetl wyniki"
          @click.prevent="formSend"
        >
      </form>
      <div id="result" v-if="JSONerror">
        <h2>Podano zły okres</h2>
      </div>
      <div id="result" v-if="isResponse && !JSONerror">
        <h2>Wyniki dla czujnika "{{responseMax.sensorName}}" za okres {{responsePeriod}}:</h2>

        <p
          v-show="windDirectionIndex !== sensorIndex"
        >Najwyższy odczyt: {{responseMax.value}}{{responseMax.unit}}</p>
        <p
          v-show="windDirectionIndex !== sensorIndex"
        >Najniższy odczyt: {{responseMin.value}}{{responseMin.unit}}</p>
        <p
          v-show="windDirectionIndex !== sensorIndex"
        >Średni odczyt: {{responseAvg.value}}{{responseAvg.unit}}</p>
        <p v-show="sensorIndex==rainIndex">Suma: {{responseSum.value}}{{responseMax.unit}}</p>
        <p
          v-show="sensorIndex==windDirectionIndex"
        >Dominującym kierunkiem wiatru był: {{responseMax.value}}{{responseMax.unit}}</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "ArchivesForm",
  components: {},
  props: {
    sensorsNames: Array
  },
  data() {
    return {
      url: "",
      sensorIndex: 0,
      year: 2018,
      useMonth: true,
      month: 1,
      useDay: true,
      day: 1,
      useHour: true,
      hour: 1,
      isResponse: false,
      responseMax: [],
      responseMin: [],
      responseAvg: [],
      responseSum: [],
      responsePeriod: "",
      JSONerror: false,
      windDirectionIndex: -1,
      rainIndex: -1
    };
  },
  methods: {
    formSend(e) {
      this.isResponse = false;
      this.JSONerror = false;
      const now = new Date();
      const dateForm = new Date(this.year, this.month - 1, this.day, this.hour);
      // console.log("Teraz: " + now);
      // console.log("Podana: " + dateForm);
      // console.log(now - dateForm);

      if (now - dateForm < 0) {
        this.JSONerror = true;
        return null;
      }

      // http://wachcio.pl/meteo_test/API/GetJSON.php?year=2018&month=12&day=1&hour=12&sensor=0&operation=min
      let result =
        "http://wachcio.pl/meteo_test/API/GetJSON.php?year=" +
        this.year +
        "&sensor=" +
        this.sensorIndex;

      this.responsePeriod = this.year;

      if (this.useMonth) {
        result += "&month=" + this.month;
        this.responsePeriod += "-" + this.month;
      }
      if (this.useDay) {
        result += "&day=" + this.day;
        this.responsePeriod += "-" + this.day;
      }
      if (this.useHour) {
        result += "&hour=" + this.hour;
        this.responsePeriod += " godzina " + this.hour;
      }
      this.url = result;
      this.getJSON();
    },
    getJSON() {
      this.isResponse = false;

      if (this.sensorIndex == this.rainIndex) {
        axios
          .get(this.url + "&operation=sum")
          .then(res => (this.responseSum = res.data));
      }

      axios
        .get(this.url + "&operation=max")
        .then(res => (this.responseMax = res.data));

      axios
        .get(this.url + "&operation=min")
        .then(res => (this.responseMin = res.data));

      axios
        .get(this.url + "&operation=avg")
        .then(res => (this.responseAvg = res.data))
        .then((this.isResponse = true));
    }
  },
  computed: {},
  created() {
    let now = new Date();

    this.year = now.getFullYear();
    this.month = now.getMonth() + 1;
    this.day = now.getDate();
    this.hour = now.getHours();

    this.rainIndex = this.sensorsNames.findIndex(function(element) {
      return element == "Opady";
    });
    this.windDirectionIndex = this.sensorsNames.findIndex(function(element) {
      return element == "Kierunek wiatru";
    });
  },
  watch: {
    useMonth(newValue, oldValue) {
      if (newValue == false) {
        this.useDay = false;
        this.useHour = false;
      }
    },
    useDay(newValue, oldValue) {
      if (newValue == false) {
        this.useHour = false;
      }
    }
    // rainIndex(newValue, oldValue){
    // rainIndex == sensorIndex
    // }
  }
};
</script>

<style type="scss" scoped>
.wrapper {
  flex-direction: column;
  justify-content: center;
}

.archiveFormContainer {
  display: flex;
  align-items: center;
  flex-direction: column;
}

.archiveFormContainer label {
  margin-bottom: 15px;
}

#archiveForm {
  display: flex;
  align-items: center;
}

#archiveForm input {
  height: 45px;
  margin: 5px;
  color: #c7eafd;
  font-family: "Lato", sans-serif;
  font-size: 20px;
  font-style: italic;
  text-shadow: 4px 4px 11px rgba(0, 0, 0, 1);
  background-color: #01335c;
}

input[type="submit"],
input[type="month"],
input[type="number"],
input[type="checkbox"],
select {
  background-color: #c7eafd;
  color: #666;
  border: 2px solid #c7eafd;
  border-radius: 5px;
  font-size: 20px;
  padding: 7px 7px;
  box-sizing: border-box;
  outline: none;
  margin-top: 5px;
  margin-bottom: 10px;
}

input[type="submit"],
select {
  /* width: 250px; */
  background-color: #01335c;
  color: #c7eafd;
  border: 2px solid #c7eafd;
  border-radius: 5px;
  font-size: 20px;
  padding: 7px 7px;
  box-sizing: border-box;
  outline: none;
}

button[type=submit]:focus,
input[type=number]:focus,
input[type=month]:focus,
 /* input[type=checkbox]:focus, */
select:focus {
  box-shadow: 0px 0px 10px 2px#c7eafd;
  /* background-color: #c7eafd; */
  /* color: #0369b2; */
}

#archiveDay:disabled,
#archiveHour:disabled {
  background-color: #68bafb;
}

.checkboxGroup {
  display: flex;
  align-items: flex-end;
}
#result {
  margin-top: 20px;
}
label {
  margin: 0 3px 0 3px;
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

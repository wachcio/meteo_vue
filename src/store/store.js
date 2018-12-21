import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";

Vue.use(Vuex);

export default new Vuex.Store({
   state: {
      endpoints: {
         endpointCurrent:
            "http://wachcio.pl/meteo_vue/API/GetJSON.php?data=current",
         endpointNames:
            "http://wachcio.pl/meteo_test/API/GetJSON.php?getSensorName=all"
      },
      sensorsCurrent: [],
      isLoaded: false,
      showInfo: false,
      currentDate: undefined
   },
   getters: {
      //szablon funkcji
      //    funkcja(message) {
      //   return state.message;
      //    }
   },
   mutations: {
      //Mutacje synhroniczne
      // W komponencie do zmiany w state będzie służyła funkcja w methods
      // update(e,type) {
      //     this.$store.commit("update", {
      //         message: e.target.value
      //     })
      // }
      updateSensorsCurrent(state, payload) {
         state.sensorsCurrent = payload;
      },
      isLoaded(state, payload) {
         state.isLoaded = payload;
      },
      timer(state, payload) {
         state.currentDate = payload;
      }
   },
   actions: {
      //Akcje są asynhroniczne np do JSON-a
      //akcje wywołujemy za pomocą dispatch z innych komponentów

      getCurrentJSON(context, payload) {
         axios
            .get(context.state.endpoints.endpointCurrent)
            .then(res => context.commit("updateSensorsCurrent", res.data))
            .then(context.commit("isLoaded", true));
      }
   }
});

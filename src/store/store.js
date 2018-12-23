import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";
import _ from "lodash";

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
      currentDate: undefined,
      sensorActive: undefined
      // winSpeedIndex: undefined,
      // windDirectionIndex: undefined
   },
   getters: {
      //szablon funkcji
      //    funkcja(message) {
      //   return state.message;
      //    }
      // winSpeedIndex(state) {
      //    return _.findIndex(state.sensorsCurrent, {
      //       sensorName: "Prędkość wiatru km/h"
      //    });
      // }
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
         const indexSpeed = _.findIndex(state.sensorsCurrent, {
            sensorName: "Prędkość wiatru km/h"
         });
         // state.winSpeedIndex = indexSpeed;
         const indexDirection = _.findIndex(state.sensorsCurrent, {
            sensorName: "Kierunek wiatru"
         });
         // state.windDirectionIndex = indexDirection;

         if (state.sensorsCurrent[indexSpeed].valueCurrent.value == 0) {
            state.sensorsCurrent[indexDirection].valueCurrent.value =
               "bezwietrznie";
            state.sensorsCurrent[indexDirection].picture =
               "assets/strzalka_przezroczysta.png";
         }
      },

      isLoadedChange(state, payload) {
         state.isLoaded = payload;
      },
      timer(state, payload) {
         state.currentDate = payload;
      },
      showInfo(state, payload) {
         state.showInfo = payload;
      },
      sensorActive(state, payload) {
         state.sensorActive = payload;
      },
      changeWindSpeedIndex(state, payload) {
         state.WindSpeedIndex = payload;
      }
   },
   actions: {
      //Akcje są asynhroniczne np do JSON-a
      //akcje wywołujemy za pomocą dispatch z innych komponentów
      getCurrentJSON(context) {
         context.commit("isLoadedChange", false);
         axios
            .get(context.state.endpoints.endpointCurrent)
            .then(res => context.commit("updateSensorsCurrent", res.data))
            .then(context.commit("isLoadedChange", true));
      }
   }
});

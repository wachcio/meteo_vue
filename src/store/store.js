import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
   state: {
      message: "Hello World!",
      endpoints: {
         endpointCurrent:
            "http://wachcio.pl/meteo_vue/API/GetJSON.php?data=current",
         endpointNames:
            "http://wachcio.pl/meteo_test/API/GetJSON.php?getSensorName=all"
      }
   },
   getters: {
      //szablon funkcji
      //    funkcja(message) {
      //   return state.message;
      //    }
   },
   mutations: {
      // W komponencie do zmiany w state będzie służyła funkcja w methods
      // update(e,type) {
      //     this.$store.commit("update", {
      //         message: e.target.value
      //     })
      // }
      update(state) {
         state.message = "Inna wiadomość";
      }
   }
});

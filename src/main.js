import Vue from "vue";
import App from "./App.vue";

Vue.config.productionTip = false;

new Vue({
   render: h =>
      h(App, {
         props: {
            endpointCurrent:
               "http://wachcio.pl/meteo_test/API/GetJSON.php?data=current"
         }
      })
}).$mount("#app");

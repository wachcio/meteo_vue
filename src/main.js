import "./css/main.scss";
import Vue from "vue";
import VueRouter from "vue-router";
import App from "./App";
import routes from "./routes/Routes";

const router = new VueRouter({
   routes
});

Vue.use(VueRouter);
Vue.config.productionTip = false;

/* eslint-disable no-new */
new Vue({
   el: "#app",
   router,
   render: h =>
      h(App, {
         props: {
            endpointCurrent:
               "http://wachcio.pl/meteo_vue/API/GetJSON.php?data=current"
         }
      })
});

import "./css/main.scss";
import Vue from "vue";
import VueRouter from "vue-router";
import App from "./App.vue";
import routes from "./routers/Routes";

const router = new VueRouter({
   routes
});

Vue.use(VueRouter);
Vue.config.productionTip = false;

new Vue({
   router,
   render: h =>
      h(App, {
         props: {
            endpointCurrent:
               "http://wachcio.pl/meteo_vue/API/GetJSON.php?data=current"
         }
      })
}).$mount("#app");

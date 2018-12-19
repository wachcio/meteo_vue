import SensorCategory from "../components/Sensor/SensorCategory.vue";
import ArchivesMain from "../components/Archives/ArchivesMain.vue";

export default [
   {
      path: "/",
      component: SensorCategory
   },
   {
      path: "/current",
      component: SensorCategory
   },
   {
      path: "/archive",
      component: ArchivesMain
   }
];

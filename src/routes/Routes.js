import SensorCategory from "../components/Sensor/SensorCategory";
import ArchivesMain from "../components/Archives/ArchivesMain";
import About from "../components/About";

export default [
   {
      path: "/",
      redirect: "/current"
   },
   {
      path: "/current",
      component: SensorCategory
   },
   {
      path: "/archive",
      component: ArchivesMain
   },
   {
      path: "/about",
      component: About
   }
];

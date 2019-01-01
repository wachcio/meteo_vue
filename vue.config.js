module.exports = {
   baseUrl: process.env.NODE_ENV === "production" ? "/meteo_vue/" : "/",
   configureWebpack: {
      devtool:
         process.env.NODE_ENV === "production"
            ? ""
            : "cheap-module-eval-source-map"
   }
};

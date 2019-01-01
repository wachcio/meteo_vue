var FtpDeploy = require("ftp-deploy");
var ftpDeploy = new FtpDeploy();

var config = {
   user: "wachcio", // NOTE that this was username in 1.x
   password: "dx0663382", // optional, prompted if none given
   host: "wachcio.home.pl",
   port: 21,
   localRoot: __dirname + "/dist",
   remoteRoot: "/public_html/wachcio/meteo_vue",
   // include: ['*', '**/*'],      // this would upload everything except dot files
   include: ["dist/*"],
   //exclude: ["dist/**/*.map"], // e.g. exclude sourcemaps - ** exclude: [] if nothing to exclude **
   deleteRemote: true, // delete existing files at destination before uploading
   forcePasv: true // Passive mode is forced (EPSV command is not sent)
};

// use with promises
ftpDeploy
   .deploy(config)
   .then(res => console.log("finished:", res))
   .catch(err => console.log(err));

// use with callback
ftpDeploy.deploy(config, function(err, res) {
   if (err) console.log(err);
   else console.log("finished:", res);
});
ftpDeploy.on("uploading", function(data) {
   //    console.log("Uploading: " + data);

   data.totalFilesCount; // total file count being transferred
   data.transferredFileCount; // number of files transferred
   data.filename; // partial path with filename being uploaded
});
ftpDeploy.on("uploaded", function(data) {
   console.log(data); // same data as uploading event
});
ftpDeploy.on("log", function(data) {
   console.log(data); // same data as uploading event
});
ftpDeploy.on("upload-error", function(data) {
   console.log(data.err); // data will also include filename, relativePath, and other goodies
});

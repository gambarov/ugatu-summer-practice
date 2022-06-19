const mix = require("laravel-mix");

// mix.js("resources/js/app.js", "public/js").postCss(
//     "resources/css/app.css",
//     "public/css",
//     [
//         //
//     ]
// );

mix.ts("resources/js/index.tsx", "public/js").react();

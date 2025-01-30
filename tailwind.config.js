/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: false,
  content: [
    "./index.php",
    "./views/**/*.php",
    "node_modules/preline/dist/*.js",
  ],
  theme: {
    extend: {},
  },
  plugins: [require("@tailwindcss/forms"), require("preline/plugin")],
};

import "./shift/index.js";

document.getElementById("create-shift-button").addEventListener(
  "click",
  function (event) {
    const dialog = document.querySelector("shift-dialog-creation");
    dialog.setAttribute("open", "true");
  },
  true
);

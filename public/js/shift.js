import "./shift/index.js";

window.addEventListener(
  "open-shift-dialog-application",
  /**
   * @param {CustomEvent} event
   */
  function (event) {
    const dialog = document.querySelector("shift-dialog-application");
    dialog.setAttribute("open", "true");
    dialog.setAttribute("calendar-id", event.detail.calendarId);
    dialog.setAttribute("shift-id", event.detail.shiftId);
    dialog.setAttribute("shift-position", event.detail.shiftPosition);
    dialog.setAttribute("publisher-id", event.detail.publisherId);
  }
);

window.addEventListener(
  "open-shift-dialog-publisher",
  /**
   * @param {CustomEvent} event
   */
  async function (event) {
    const dialog = document.querySelector("shift-dialog-publisher");
    dialog.setAttribute("open", "true");
    dialog.setAttribute("calendar-id", event.detail.calendarId);
    dialog.setAttribute("shift-id", event.detail.shiftId);
    dialog.setAttribute("shift-position", event.detail.shiftPosition);
    dialog.setAttribute("publisher-id", event.detail.publisherId);
    dialog.setAttribute("editable", event.detail.editable);
  }
);

document.getElementById("create-shift-button").addEventListener(
  "click",
  function (event) {
    const dialog = document.querySelector("shift-dialog-creation");
    dialog.setAttribute("open", "true");
  },
  true
);

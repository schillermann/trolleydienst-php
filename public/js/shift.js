import { ShiftNavButtonNewShift, ShiftDialogCreation } from "./shift/index.js";

customElements.get("shift-nav-button-new-shift") ||
  window.customElements.define(
    "shift-nav-button-new-shift",
    ShiftNavButtonNewShift
  );

customElements.get("shift-dialog-creation") ||
  window.customElements.define("shift-dialog-creation", ShiftDialogCreation);

window.addEventListener(
  "open-shift-dialog-application",
  /**
   * @param {CustomEvent} event
   */
  function (event) {
    const dialog = document.querySelector("shift-dialog-application");
    dialog.setAttribute("open", "true");
    dialog.setAttribute("shift-id", event.detail.shiftId);
    dialog.setAttribute("shift-position", event.detail.shiftPosition);
  }
);

// TODO: split in open-shift-dialog-publisher-action and open-shift-dialog-publisher-contact
window.addEventListener(
  "open-shift-dialog-publisher-contact",
  /**
   * @param {CustomEvent} event
   */
  async function (event) {
    const apiUrl = "/api/me";
    const response = await fetch(apiUrl, {
      method: "GET",
      headers: { "Content-Type": "application/json" },
    });

    if (response.status !== 200) {
      console.error("Can not read the details of the logged in publisher");
      return;
    }

    const loggedInPublisher = await response.json();

    if (loggedInPublisher.id === event.detail.publisherId) {
      const dialog = document.querySelector("shift-dialog-publisher");
      dialog.setAttribute("open", "true");
      dialog.setAttribute("shift-id", event.detail.shiftId);
      dialog.setAttribute("shift-type-id", event.detail.shiftTypeId);
      dialog.setAttribute("shift-position", event.detail.shiftPosition);
      dialog.setAttribute("publisher-id", event.detail.publisherId);
      return;
    }

    const dialog = document.querySelector("shift-dialog-publisher-contact");
    dialog.setAttribute("open", "true");
    dialog.setAttribute("publisher-id", event.detail.publisherId);
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

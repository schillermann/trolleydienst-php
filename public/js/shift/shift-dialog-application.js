"use strict";

import { DialogButtonPrimary, DialogButton } from "../button/index.js";
import { Dictionary } from "../dictionary.js";
import { FrontierElement } from "../frontier-element.js";
import { ShiftDialogSelectmenuPublishers } from "./shift-dialog-selectmenu-publishers.js";

export class ShiftDialogApplication extends FrontierElement {
  #selectedPublisherId;

  static observedAttributes = ["open", "lang", "logged-in-publisher-id"];

  constructor() {
    super();

    this.dictionary = new Dictionary({
      "Shift Application": {
        de: "Schicht Bewerbung",
      },
      Apply: {
        de: "Bewerben",
      },
      Cancel: {
        de: "Abbrechen",
      },
    });
  }

  /**
   * @param {Event} event
   * @returns {void}
   */
  closeDialog(event) {
    this.setAttribute("open", "false");
  }

  /**
   * @param {Event} event
   * @returns {void}
   */
  async sendShiftApplication(event) {
    const response = await fetch(
      "/api/shifts/" +
        this.getAttribute("shift-id") +
        "/positions/" +
        this.getAttribute("shift-position") +
        "/publishers",
      {
        method: "POST",
        body: JSON.stringify({
          publisherId: this.#selectedPublisherId,
        }),
      }
    );

    if (response.status === 201) {
      this.setAttribute("open", "false");
    }
  }

  /**
   * @param {Event} event
   * @returns {void}
   */
  setSelectedPublisherId(event) {
    this.#selectedPublisherId = event.detail.publisherId;
  }

  connectedCallback() {
    customElements.get("dialog-button-primary") ||
      window.customElements.define(
        "dialog-button-primary",
        DialogButtonPrimary
      );
    customElements.get("dialog-button") ||
      window.customElements.define("dialog-button", DialogButton);
    customElements.get("shift-dialog-selectmenu-publishers") ||
      window.customElements.define(
        "shift-dialog-selectmenu-publishers",
        ShiftDialogSelectmenuPublishers
      );

    this.shadowRoot.addEventListener(
      "selectmenu-change",
      this.setSelectedPublisherId.bind(this)
    );

    this.shadowRoot
      .getElementById("button-apply")
      .addEventListener("click", this.sendShiftApplication.bind(this));
    this.shadowRoot
      .getElementById("button-cancel")
      .addEventListener("click", this.closeDialog.bind(this));
  }

  disconnectedCallback() {
    this.shadowRoot.removeEventListener(
      "selectmenu-change",
      this.setSelectedPublisherId
    );

    this.shadowRoot
      .getElementById("button-apply")
      .removeEventListener("click", this.closeDialog);
    this.shadowRoot
      .getElementById("button-cancel")
      .removeEventListener("click", this.sendShiftApplication);
  }

  attributeChangedCallback(name, oldVal, newVal) {
    this.render();
    if (name === "open") {
      const dialog = this.shadowRoot.querySelector("dialog");
      if (newVal === "true") {
        dialog.showModal();
        return;
      }
      dialog.close();
      return;
    }

    if (name === "lang") {
      this.shadowRoot.innerHTML = this.dictionary.innerHTMLEnglishTo(
        newVal,
        this.shadowRoot.innerHTML
      );
      return;
    }

    if (name === "logged-in-publisher-id") {
      this.shadowRoot
        .querySelector("shift-dialog-selectmenu-publishers")
        .setAttribute("selected-publisher-id", newVal);
      return;
    }
  }

  /**
   * @returns {string}
   */
  template() {
    return /*html*/ `
      <style></style>

      <dialog>
        <header>
          <h2>{Shift Application}</h2>
        </header>
        <div>
          <img src="images/gadgets.svg">
        </div>
        <div>
          <shift-dialog-selectmenu-publishers></shift-dialog-selectmenu-publishers>
          <dialog-button-primary id="button-apply">
            {Apply}
          </dialog-button-primary>
          <dialog-button id="button-cancel">
            {Cancel}
          </dialog-button>
        </div>
      </dialog>
    `;
  }
}

"use strict";

import { DialogButtonPrimary } from "../dialog/dialog-button-primary.js";
import { DialogButton } from "../dialog/dialog-button.js";
import { Dictionary } from "../dictionary.js";
import { ShiftDialogSelectmenuPublishers } from "./shift-dialog-selectmenu-publishers.js";

const template = document.createElement("template");
template.innerHTML = /*html*/ `
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

export class ShiftDialogApplication extends HTMLElement {
  dictionary: Dictionary;
  selectedPublisherId: number;

  static observedAttributes = [
    "open",
    "language-code",
    "logged-in-publisher-id",
  ];

  constructor() {
    super();

    this.attachShadow({ mode: "closed" }).appendChild(
      template.content.cloneNode(true)
    );

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

  closeDialog(event: Event): void {
    this.setAttribute("open", "false");
  }

  async sendShiftApplication(event: Event) {
    const response = await fetch("/api/shift/register-publisher-for-shift", {
      method: "POST",
      body: JSON.stringify({
        shiftDayId: this.getAttribute("shift_day_id"),
        shiftId: this.getAttribute("shift_id"),
        publisherId: this.selectedPublisherId,
      }),
    });

    if (response.status === 201) {
      this.setAttribute("open", "false");
    }
  }

  setSelectedPublisherId(event: CustomEvent): void {
    this.selectedPublisherId = event.detail.publisherId;
  }

  connectedCallback() {
    customElements.get("dialog-button-primary") ||
      window.customElements.define(
        "dialog-button-primary",
        DialogButtonPrimary,
      );
    customElements.get("dialog-button") ||
      window.customElements.define("dialog-button", DialogButton);
    customElements.get("shift-dialog-selectmenu-publishers") ||
      window.customElements.define(
        "shift-dialog-selectmenu-publishers",
        ShiftDialogSelectmenuPublishers,
      );

    this.shadowRoot.addEventListener(
      "selectmenu-change",
      this.setSelectedPublisherId.bind(this),
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
      this.setSelectedPublisherId,
    );

    this.shadowRoot
      .getElementById("button-apply")
      .removeEventListener("click", this.closeDialog);
    this.shadowRoot
      .getElementById("button-cancel")
      .removeEventListener("click", this.sendShiftApplication);
  }

  attributeChangedCallback(name: string, oldVal: string, newVal: string) {
    if (name === "open") {
      const dialog = this.shadowRoot.querySelector("dialog");
      if (newVal === "true") {
        dialog.showModal();
        return;
      }
      dialog.close();
      return;
    }

    if (name === "language-code") {
      this.shadowRoot.innerHTML = this.dictionary.innerHTMLEnglishTo(
        newVal,
        this.shadowRoot.innerHTML,
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
}

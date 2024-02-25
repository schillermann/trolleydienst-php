"use strict";

import "../button/index.js";
import "./shift-dialog-selectmenu-publishers.js";
import { FrontierElement } from "../frontier-element.js";

export class ShiftDialogApplication extends FrontierElement {
  static observedAttributes = ["open", "lang", "publisher-id"];
  #errorMessage = "";

  constructor() {
    super();
  }

  /**
   * @param {Event} event
   * @returns {void}
   */
  closeDialog(event) {
    this.setAttribute("open", "false");
  }

  /**
   * @returns {void}
   */
  disconnectedCallback() {
    this.shadowRoot
      .getElementById("button-apply")
      .removeEventListener("click", this.sendShiftApplication);
    this.shadowRoot
      .getElementById("button-cancel")
      .removeEventListener("click", this.closeDialog);
  }

  /**
   * @returns {Promise<void>}
   */
  async update() {
    await super.update();
    const dialog = this.shadowRoot.querySelector("dialog");
    if (this.getAttribute("open") === "true") {
      dialog.showModal();
    } else {
      dialog.close();
    }
  }

  /**
   * @param {string} template
   * @returns {void}
   */
  render(template) {
    super.render(template);

    this.shadowRoot
      .getElementById("button-apply")
      .addEventListener("click", this.sendShiftApplication.bind(this));
    this.shadowRoot
      .getElementById("button-cancel")
      .addEventListener("click", this.closeDialog.bind(this));
  }

  /**
   * @param {Event} event
   * @returns {Promise<void>}
   */
  async sendShiftApplication(event) {
    const apiUrl =
      "/api/calendars/1/shifts/" +
      this.getAttribute("shift-id") +
      "/positions/" +
      this.getAttribute("shift-position") +
      "/publishers/" +
      this.getAttribute("publisher-id") +
      "/applications";

    const response = await fetch(apiUrl, {
      method: "POST",
    });

    if (response.status === 409) {
      this.#errorMessage = this.errorConflict();
      await this.update();
      return;
    }

    if (response.status === 204) {
      this.dispatchEvent(
        new CustomEvent("update-calendar", {
          bubbles: true,
          cancelable: false,
          composed: true,
        })
      );
    }
  }

  errorConflict() {
    switch (this.getAttribute("lang")) {
      case "de":
        return "Du hast dich bereits in dieser Schicht beworben";
      default:
        return "You have already applied for this shift";
    }
  }

  /**
   * @returns {string}
   */
  labelHeader() {
    switch (this.getAttribute("lang")) {
      case "de":
        return "Schicht Bewerbung";
      default:
        return "Shift Application";
    }
  }

  /**
   * @returns {string}
   */
  labelApply() {
    switch (this.getAttribute("lang")) {
      case "de":
        return "Bewerben";
      default:
        return "Apply";
    }
  }

  /**
   * @returns {string}
   */
  labelCancel() {
    switch (this.getAttribute("lang")) {
      case "de":
        return "Abbrechen";
      default:
        return "Cancel";
    }
  }

  /**
   * @returns {string}
   */
  template() {
    const publisherId = this.getAttribute("publisher-id");

    return /*html*/ `
      <style></style>

      <dialog>
        <header>
          <h2>${this.labelHeader()}</h2>
        </header>
        <div>
          <img src="images/gadgets.svg">
        </div>
        <div>
          <p>${this.#errorMessage}</p>
          <shift-dialog-selectmenu-publishers default-publisher-id="${publisherId}"></shift-dialog-selectmenu-publishers>
          <dialog-button-primary id="button-apply">
            ${this.labelApply()}
          </dialog-button-primary>
          <dialog-button id="button-cancel">
            ${this.labelCancel()}
          </dialog-button>
        </div>
      </dialog>
    `;
  }
}

window.customElements.define(
  "shift-dialog-application",
  ShiftDialogApplication
);

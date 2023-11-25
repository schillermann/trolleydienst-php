"use strict";

import { DialogButton } from "../../dialog-button.js";
import { Dictionary } from "../../dictionary.js";

const template = document.createElement("template");
template.innerHTML = /*html*/ `
  <style></style>

  <dialog>
    <header>
      <h2>{Publisher Contact}</h2>
    </header>
    <div>
      <h3 id="publisher-name"></h3>
      <address>
        <dl>
          <dt>{Email}:</dt>
          <dd id="email"></dd>
          <dt>{Phone}:</dt>
          <dd ="phone"></dd>
          <dt>{Mobile}:</dt>
          <dd id="mobile"></dd>
        </dl>
      </address>
      <h4>{Info}</h4>
      <p id="info"></p>
    </div>
    <div>
      <dialog-button id="button-close">{Close}</dialog-button>
    </div>
  </dialog>
`;

export default class ShiftDialogPublisherPartner extends HTMLElement {
  static observedAttributes = ["open", "language-code", "publisher-id"];

  constructor() {
    super();

    this._shadowRoot = this.attachShadow({ mode: "open" });
    this._shadowRoot.appendChild(template.content.cloneNode(true));

    this.dictionary = new Dictionary({
      "Publisher Contact": {
        de: "Verkündiger Kontakt",
      },
      Email: {
        de: "E-Mail",
      },
      Phone: {
        de: "Festnetz",
      },
      Mobile: {
        de: "Mobil",
      },
      Info: {
        de: "Info",
      },
      Close: {
        de: "Schließen",
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

  connectedCallback() {
    customElements.get("dialog-button") ||
      window.customElements.define("dialog-button", DialogButton);

    this._shadowRoot
      .getElementById("button-close")
      .addEventListener("click", this.closeDialog.bind(this));
  }

  disconnectedCallback() {
    this._shadowRoot.removeEventListener("click", this.closeDialog);
  }

  /**
   * @param {number} publisherId
   * @returns {Promise<void>}
   */
  async setContactInfo(publisherId) {
    const apiUrl = "/api/publishers/" + publisherId;
    const response = await fetch(apiUrl, {
      method: "GET",
      headers: { "Content-Type": "application/json" },
    });

    if (response.status !== 200) {
      console.error("Cannot read publisher from api [url: " + apiUrl + "]");
      return;
    }
    const publisher = await response.json();
    this._shadowRoot.getElementById("email").textContent = publisher.email;
    if (publisher.phone) {
      this._shadowRoot.getElementById("phone").textContent = publisher.phone;
    }
    if (publisher.mobile) {
      this._shadowRoot.getElementById("mobile").textContent = publisher.mobile;
    }
    if (publisher.publisherNote) {
      this._shadowRoot.getElementById("info").textContent =
        publisher.publisherNote;
    }
  }

  /**
   * @param {string} name
   * @param {string} oldVal
   * @param {string} newVal
   * @returns {Promise<void>}
   */
  async attributeChangedCallback(name, oldVal, newVal) {
    if (name === "language-code") {
      this._shadowRoot.innerHTML = this.dictionary.innerHTMLEnglishTo(
        newVal,
        this._shadowRoot.innerHTML,
      );
      return;
    }

    if (name === "open") {
      const dialog = this._shadowRoot.querySelector("dialog");
      if (newVal === "true") {
        dialog.showModal();
        return;
      }
      dialog.close();
      return;
    }

    if (name === "publisher-id") {
      await this.setContactInfo(this.getAttribute("publisher-id"));
    }
  }
}

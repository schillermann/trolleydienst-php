"use strict";

import { DialogButton } from "./../button/index.js";
import { Dictionary } from "../dictionary.js";
import { FrontierElement } from "../frontier-element.js";

export class ShiftDialogPublisherContact extends FrontierElement {
  static observedAttributes = ["open", "lang", "publisher-id"];

  constructor() {
    super();

    // this.dictionary = new Dictionary({
    //   "Publisher Contact": {
    //     de: "Verkündiger Kontakt",
    //   },
    //   Email: {
    //     de: "E-Mail",
    //   },
    //   Phone: {
    //     de: "Festnetz",
    //   },
    //   Mobile: {
    //     de: "Mobil",
    //   },
    //   "Info From Publisher": {
    //     de: "Info vom Verkündiger",
    //   },
    //   Close: {
    //     de: "Schließen",
    //   },
    // });
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

    this.shadowRoot
      .getElementById("button-close")
      .addEventListener("click", this.closeDialog.bind(this));
  }

  disconnectedCallback() {
    this.shadowRoot.removeEventListener("click", this.closeDialog);
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
    const email = this.shadowRoot.getElementById("email");
    email.href = "mailto:" + publisher.email;
    email.textContent = publisher.email;

    if (publisher.phone) {
      const phone = this.shadowRoot.getElementById("phone");
      phone.href = "tel:" + publisher.phone;
      phone.textContent = publisher.phone;
    }
    if (publisher.mobile) {
      const mobile = this.shadowRoot.getElementById("mobile");
      mobile.href = publisher.mobile;
      mobile.textContent = publisher.mobile;
    }
    if (publisher.publisherNote) {
      this.shadowRoot.getElementById("info").textContent =
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
    this.render();
    if (name === "lang") {
      // this.shadowRoot.innerHTML = this.dictionary.innerHTMLEnglishTo(
      //   newVal,
      //   this.shadowRoot.innerHTML
      // );
      return;
    }

    if (name === "open") {
      const dialog = this.shadowRoot.querySelector("dialog");
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

  /**
   * @returns {string}
   */
  template() {
    return /*html*/ `
      <style></style>
    
      <dialog>
        <header>
          <h2 id="publisher-contract">{Publisher Contact}</h2>
        </header>
        <div>
          <h3 id="publisher-name"></h3>
          <address>
            <dl>
              <dt>{Email}:</dt>
              <dd><a id="email"></a></dd>
              <dt>{Phone}:</dt>
              <dd><a id="phone"></a></dd>
              <dt>{Mobile}:</dt>
              <dd><a id="mobile"></a></dd>
            </dl>
          </address>
          <h4>{Info From Publisher}</h4>
          <p id="info"></p>
        </div>
        <div>
          <dialog-button id="button-close">{Close}</dialog-button>
        </div>
      </dialog>
    `;
  }
}

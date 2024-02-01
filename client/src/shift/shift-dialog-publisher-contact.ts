"use strict";

import { DialogButton } from "../dialog/dialog-button";
import { Dictionary } from "../dictionary";

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

export class ShiftDialogPublisherContact extends HTMLElement {
  dictionary: Dictionary;
  static observedAttributes = ["open", "language-code", "publisher-id"];

  constructor() {
    super();

    this.attachShadow({ mode: "closed" }).appendChild(
      template.content.cloneNode(true)
    );

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
      "Info From Publisher": {
        de: "Info vom Verkündiger",
      },
      Close: {
        de: "Schließen",
      },
    });
  }

  closeDialog(event: Event): void {
    this.setAttribute("open", "false");
  }

  connectedCallback(): void {
    customElements.get("dialog-button") ||
      window.customElements.define("dialog-button", DialogButton);

    this.shadowRoot
      .getElementById("button-close")
      .addEventListener("click", this.closeDialog.bind(this));
  }

  disconnectedCallback(): void {
    this.shadowRoot.removeEventListener("click", this.closeDialog);
  }

  async setContactInfo(publisherId: number): Promise<void> {
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
    const email = this.shadowRoot.getElementById("email") as HTMLAnchorElement;
    email.href = "mailto:" + publisher.email;
    email.textContent = publisher.email;

    if (publisher.phone) {
      const phone = this.shadowRoot.getElementById("phone") as HTMLAnchorElement;
      phone.href = "tel:" + publisher.phone;
      phone.textContent = publisher.phone;
    }
    if (publisher.mobile) {
      const mobile = this.shadowRoot.getElementById("mobile") as HTMLAnchorElement;
      mobile.href = publisher.mobile;
      mobile.textContent = publisher.mobile;
    }
    if (publisher.publisherNote) {
      this.shadowRoot.getElementById("info").textContent =
        publisher.publisherNote;
    }
  }

  async attributeChangedCallback(name: string, oldVal: string, newVal: string): Promise<void> {
    if (name === "language-code") {
      this.shadowRoot.innerHTML = this.dictionary.innerHTMLEnglishTo(
        newVal,
        this.shadowRoot.innerHTML,
      );
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
      await this.setContactInfo(Number(this.getAttribute("publisher-id")));
    }
  }
}

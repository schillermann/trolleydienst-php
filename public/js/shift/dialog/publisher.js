"use strict";

import { DialogButton } from "../../dialog-button.js";
import { Dictionary } from "../../dictionary.js";

const template = document.createElement("template");
template.innerHTML = /*html*/ `
    <style>
        input {
            width: 100%;
        }
    </style>
    <dialog>
        <header>
            <h2>{Shift}</h2>
        </header>
        <div>
            <p>Publisher</p>
        </div>
        <div>
            <dialog-button>
                {Close}
            </dialog-button>
        </div>
    </dialog>
`;

export default class ShiftDialogPublisher extends HTMLElement {
  constructor() {
    super();

    this._shadowRoot = this.attachShadow({ mode: "open" });
    this._shadowRoot.appendChild(template.content.cloneNode(true));

    this.dictionary = new Dictionary({
      Close: {
        de: "Schliessen",
      },
    });
  }

  /**
   * @param {Event} event
   * @returns {void}
   */
  closeDialog(event) {
    event.currentTarget.querySelector("dialog").close();
  }

  connectedCallback() {
    customElements.get("dialog-button") ||
      window.customElements.define("dialog-button", DialogButton);

    this._shadowRoot.addEventListener("close-dialog", this.closeDialog, true);
  }

  static get observedAttributes() {
    return ["open"];
  }

  attributeChangedCallback(name, oldVal, newVal) {
    if (name === "open") {
      const dialog = this._shadowRoot.querySelector("dialog");
      if (newVal === "true") {
        dialog.showModal();
        return;
      }
      dialog.close();
      return;
    }
    if (name === "language-code") {
      this._shadowRoot.innerHTML = this.dictionary.innerHTMLEnglishTo(
        newVal,
        this._shadowRoot.innerHTML,
      );
      return;
    }
  }
}

"use strict";

import { DialogButton } from "../../dialog-button.js";
import { Dictionary } from "../../dictionary.js";
import { FrontierElement } from "../frontier-element.js";

export class ShiftDialogPublisherAction extends FrontierElement {
  static observedAttributes = ["open"];
  constructor() {
    super();

    // this.dictionary = new Dictionary({
    //   Close: {
    //     de: "Schliessen",
    //   },
    // });
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

    this.shadowRoot.addEventListener("close-dialog", this.closeDialog, true);
  }

  /**
   * @param {string} name
   * @param {string} oldVal
   * @param {string} newVal
   * @returns {void}
   */
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
  }

  /**
   * @returns {string}
   */
  template() {
    return /*html*/ `
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
                  <label id="close">Close</label>
              </dialog-button>
          </div>
      </dialog>
    `;
  }
}

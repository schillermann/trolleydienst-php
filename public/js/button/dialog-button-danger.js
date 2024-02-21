"use strict";

import { FrontierElement } from "../frontier-element.js";

export class DialogButtonDanger extends FrontierElement {
  constructor() {
    super();
  }

  /**
   * @returns {string}
   */
  template() {
    return /*html*/ `
      <style>
        button {
          background-color: var(--error-color);
          color: var(--white);
          width: 100%;
        }
      </style>
      <button>
        <slot/>
      </button>
    `;
  }
}

window.customElements.define("dialog-button-danger", DialogButtonDanger);

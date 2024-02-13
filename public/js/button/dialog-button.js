"use strict";

import { FrontierElement } from "../frontier-element.js";

export class DialogButton extends FrontierElement {
  constructor() {
    super();
  }

  async connectedCallback() {
    this.render();
  }

  /**
   * @returns {string}
   */
  template() {
    return /*html*/ `
      <style>
        button {
          width: 100%;
        }
      </style>
      <button>
        <slot/>
      </button>
    `;
  }
}

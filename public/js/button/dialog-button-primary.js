"use strict";

import { FrontierElement } from "../frontier-element.js";

export class DialogButtonPrimary extends FrontierElement {
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
          background-color: var(--main-color);
          color: var(--white);
          width: 100%;
        }
      </style>
      <button>
        <slot />
      </button> 
    `;
  }
}

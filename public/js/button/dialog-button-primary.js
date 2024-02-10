"use strict";

import { FrontierElement } from "../forntier-element.js";

export class DialogButtonPrimary extends FrontierElement {
  constructor() {
    super();
  }

  /**
   * @returns {string}
   */
  render() {
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

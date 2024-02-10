"use strict";

import { FrontierElement } from "../frontier-element.js";

export class DialogButtonDanger extends FrontierElement {
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

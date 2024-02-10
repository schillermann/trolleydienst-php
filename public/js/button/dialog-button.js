"use strict";

import { FrontierElement } from "../forntier-element.js";

export class DialogButton extends FrontierElement {
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
          width: 100%;
        }
      </style>
      <button>
        <slot/>
      </button>
    `;
  }
}

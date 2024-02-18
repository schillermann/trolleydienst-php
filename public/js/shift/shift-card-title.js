"use strict";

import { FrontierElement } from "../frontier-element.js";

export class ShiftCardTitle extends FrontierElement {
  static observedAttributes = ["date", "route-name"];

  constructor() {
    super();
  }

  /**
   * @returns {string}
   */
  template() {
    const date = new Date(this.getAttribute("date")).toDateString();
    const routeName = this.getAttribute("route-name");

    return /*html*/ `
      <style>
        h2 {
          text-align: left;
        }
      </style>
      <h2>
        ${date} - ${routeName}
      </h2>
    `;
  }
}

window.customElements.define("shift-card-title", ShiftCardTitle);

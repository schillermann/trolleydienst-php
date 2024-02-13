"use strict";

import { FrontierElement } from "../frontier-element.js";

export class ShiftCardTitle extends FrontierElement {
  #date = "XXX XXX 00 0000";
  #routeName = "Unknown";

  constructor() {
    super();
  }

  connectedCallback() {
    this.#date = new Date(this.getAttribute("date")).toDateString();
    this.#routeName = this.getAttribute("route-name");

    this.render();
  }

  /**
   * @returns {string}
   */
  template() {
    return /*html*/ `
      <style>
        h2 {
          text-align: left;
        }
      </style>
      <h2>
        ${this.#date} - ${this.#routeName}
      </h2>
    `;
  }
}

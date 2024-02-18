"use strict";

import { FrontierElement } from "../frontier-element.js";

export class ShiftCardTime extends FrontierElement {
  constructor() {
    super();
  }

  /**
   * @returns {string}
   */
  getDateFrom() {
    const dateFrom = new Date(this.getAttribute("date-from"));
    if (dateFrom.toString() === "Invalid Date") {
      throw new Error(
        "Invalid Date [date-from: " + this.getAttribute("date-from") + "]"
      );
    }
    const hours = dateFrom.getHours();
    const minutes = new String("0" + dateFrom.getMinutes()).slice(-2);
    return hours + ":" + minutes;
  }

  /**
   * @returns {string}
   */
  getDateTo() {
    const dateTo = new Date(new Date(this.getAttribute("date-to")));
    if (dateTo.toString() === "Invalid Date") {
      throw new Error(
        "Invalid Date [date-to: " + this.getAttribute("date-to") + "]"
      );
    }
    const hours = dateTo.getHours();
    const minutes = new String("0" + dateTo.getMinutes()).slice(-2);

    return hours + ":" + minutes;
  }

  /**
   * @returns {string}
   */
  template() {
    return /*html*/ `
      <p>
        <span id="date-from">${this.getDateFrom()}</span> - <span id="date-to">${this.getDateTo()}</span>
      </p>
    `;
  }
}

window.customElements.define("shift-card-time", ShiftCardTime);

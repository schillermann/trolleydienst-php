"use strict";

import { ShiftCard } from "./shift-card.js";
import { FrontierElement } from "../frontier-element.js";

/**
 * @typedef {Object} Shift
 * @property {number} id
 * @property {string} routeName
 * @property {string} start
 * @property {number} numberOfShifts
 * @property {number} minutesPerShift
 * @property {string} colorHex
 * @property {string} lastModifiedOn
 * @property {string} createdOn
 */

/**
 * @typedef {Object} Calendar
 * @property {number} id
 * @property {string} label
 * @property {number} publisherLimitPerShift
 * @property {string} info
 * @property {string} lastModifiedOn
 * @property {string} createdOn
 */

export class ShiftCardCalendar extends FrontierElement {
  constructor() {
    super();
  }

  async connectedCallback() {
    const calendar = await this.calendar();

    for (const shift of await this.shifts()) {
      const shiftCard = document.createElement("shift-card");
      shiftCard.setAttribute("date", shift.start);
      shiftCard.setAttribute("shift-id", shift.id);
      shiftCard.setAttribute("calendar-id", this.getAttribute("calendar-id"));
      shiftCard.setAttribute("color", shift.colorHex);
      shiftCard.setAttribute(
        "publisher-limit",
        calendar.publisherLimitPerShift
      );
      shiftCard.setAttribute("route-name", shift.routeName);
      shiftCard.setAttribute(
        "language-code",
        this.getAttribute("language-code")
      );

      this.shadowRoot.appendChild(shiftCard);
    }

    customElements.get("shift-card") ||
      window.customElements.define("shift-card", ShiftCard);
  }

  /**
   * @returns {Shifts[]}
   */
  async shifts() {
    const apiUrl =
      "/api/calendars/" + this.getAttribute("calendar-id") + "/shifts";
    const response = await fetch(apiUrl, {
      method: "GET",
      headers: { "Content-Type": "application/json" },
    });

    if (response.status !== 200) {
      throw new Error("Cannot read shifts from api [url: " + apiUrl + "]");
    }

    return await response.json();
  }

  /**
   * @returns {Calendar[]}
   */
  async calendar() {
    const apiUrl = "/api/calendars/" + this.getAttribute("calendar-id");
    const response = await fetch(apiUrl, {
      method: "GET",
      headers: { "Content-Type": "application/json" },
    });

    if (response.status !== 200) {
      throw new Error(
        "Cannot read shift calendar from api [url: " + apiUrl + "]"
      );
    }
    return await response.json();
  }
}

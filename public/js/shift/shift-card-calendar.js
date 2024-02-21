"use strict";

import "./shift-card.js";
import { FrontierElement } from "../frontier-element.js";

/**
 * @typedef {Object} Shift
 * @property {number} id
 * @property {string} routeName
 * @property {string} shiftStart
 * @property {number} shiftPositions
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
  static observedAttributes = ["lang", "calendar-id", "logged-in-publisher-id"];

  constructor() {
    super();
  }

  /**
   * @returns {Promise<string>}
   */
  async template() {
    /** @type {Calendar} */
    const calendar = await this.calendarJson();
    /** @type {Shift[]} */
    const shitfs = await this.shiftsJson();
    const calendarId = this.getAttribute("calendar-id");
    const lang = this.getAttribute("lang");
    const loggedInPublisherId = this.getAttribute("logged-in-publisher-id");

    return shitfs
      .map(
        /**
         * @param {Shift} shift
         * @returns {string}
         */
        (shift) => /*html*/ `<shift-card
            shift-id="${shift.id}"
            shift-start="${shift.shiftStart}"
            shift-color="${shift.colorHex}"
            shift-positions="${shift.shiftPositions}"
            minutes-per-shift="${shift.minutesPerShift}"
            calendar-id="${calendarId}"
            publisher-limit ="${calendar.publisherLimitPerShift}"
            route-name="${shift.routeName}"
            logged-in-publisher-id="${loggedInPublisherId}"
            lang="${lang}"></shift-card>`
      )
      .join("");
  }

  /**
   * @returns {Shift[]}
   */
  async shiftsJson() {
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
  async calendarJson() {
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

window.customElements.define("shift-card-calendar", ShiftCardCalendar);

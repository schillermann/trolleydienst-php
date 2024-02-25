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

  openShiftDialogPublisher(event) {
    const dialog = this.shadowRoot.querySelector("shift-dialog-publisher");
    dialog.setAttribute("open", "true");
    dialog.setAttribute("calendar-id", event.detail.calendarId);
    dialog.setAttribute("shift-id", event.detail.shiftId);
    dialog.setAttribute("shift-position", event.detail.shiftPosition);
    dialog.setAttribute("publisher-id", event.detail.publisherId);
    dialog.setAttribute("editable", event.detail.editable);
  }

  openShiftDialogApplication(event) {
    const dialog = this.shadowRoot.querySelector("shift-dialog-application");
    dialog.setAttribute("open", "true");
    dialog.setAttribute("calendar-id", event.detail.calendarId);
    dialog.setAttribute("shift-id", event.detail.shiftId);
    dialog.setAttribute("shift-position", event.detail.shiftPosition);
    dialog.setAttribute("publisher-id", event.detail.publisherId);
  }

  async connectedCallback() {
    await super.connectedCallback();

    this.shadowRoot.addEventListener(
      "open-shift-dialog-publisher",
      this.openShiftDialogPublisher.bind(this)
    );
    this.shadowRoot.addEventListener(
      "open-shift-dialog-application",
      this.openShiftDialogApplication.bind(this)
    );
    this.shadowRoot.addEventListener(
      "update-calendar",
      super.forceUpdate.bind(this)
    );
  }

  disconnectedCallback() {
    this.shadowRoot.removeEventListener(
      "open-shift-dialog-publisher",
      this.openShiftDialogPublisher
    );
    this.shadowRoot.removeEventListener(
      "open-shift-dialog-application",
      this.openShiftDialogPublisher
    );
    this.shadowRoot.removeEventListener("update-calendar", super.forceUpdate);
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

    return /*html*/ `<shift-dialog-publisher lang="en" open="false"></shift-dialog-publisher>
      <shift-dialog-application lang="en" open="false"></shift-dialog-application>
      ${shitfs
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
        .join("")}`;
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

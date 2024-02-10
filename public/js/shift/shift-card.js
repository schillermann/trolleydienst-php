"use strict";

import { ShiftCardPosition } from "./shift-card-position.js";
import { ShiftCardTitle } from "./shift-card-title.js";
import { ShiftCardButtonEdit } from "./shift-card-button-edit.js";
import { FrontierElement } from "../frontier-element.js";

/**
 * @typedef {Object} Shift
 * @property {number} typeId
 * @property {string} routeName
 * @property {string} start
 * @property {number} numberOfShifts
 * @property {number} minutesPerShift
 * @property {string} colorHex
 * @property {string} lastModifiedOn
 * @property {string} createdOn
 */

/**
 * @typedef {Object} Applications
 * @property {number} shiftPosition
 * @property {Publisher} publisher
 * @property {string} createdOn
 */

/**
 * @typedef {Object} Publisher
 * @property {number} id
 * @property {string} firstname
 * @property {string} lastname
 */

export class ShiftCard extends FrontierElement {
  constructor() {
    super();
  }

  async connectedCallback() {
    /** @type {Element} */
    const shiftCardTitle = this.shadowRoot.querySelector("shift-card-title");
    shiftCardTitle.setAttribute("date", this.getAttribute("date"));
    shiftCardTitle.setAttribute("route-name", this.getAttribute("route-name"));

    customElements.get("shift-card-title") ||
      window.customElements.define("shift-card-title", ShiftCardTitle);
    customElements.get("shift-card-position") ||
      window.customElements.define("shift-card-position", ShiftCardPosition);
    customElements.get("shift-card-button-edit") ||
      window.customElements.define(
        "shift-card-button-edit",
        ShiftCardButtonEdit
      );

    const shift = await this.shift();
    const applications = await this.applications();
    const shiftPositionSection =
      this.shadowRoot.getElementById("shift-position");

    for (
      let shiftPosition = 1;
      shiftPosition <= shift.numberOfShifts;
      shiftPosition++
    ) {
      const shiftPositionElement = document.createElement(
        "shift-card-position"
      );

      const publishers = {};
      for (const application of applications) {
        if (application.shiftPosition !== shiftPosition) {
          continue;
        }
        publishers[application.publisher.id] =
          application.publisher.firstname +
          " " +
          application.publisher.lastname;
      }

      shiftPositionElement.setAttribute(
        "publishers",
        JSON.stringify(publishers)
      );
      shiftPositionElement.setAttribute(
        "shift-id",
        this.getAttribute("shift-id")
      );
      shiftPositionElement.setAttribute(
        "calendar-id",
        this.getAttribute("calendar-id")
      );
      shiftPositionElement.setAttribute("shift-position", shiftPosition);
      // TODO: calculate time from to
      shiftPositionElement.setAttribute("from", "2023-12-20");
      shiftPositionElement.setAttribute("to", "2023-12-21");
      shiftPositionElement.setAttribute(
        "language-code",
        this.getAttribute("language-code")
      );
      shiftPositionElement.setAttribute(
        "publisher-limit",
        this.getAttribute("publisher-limit")
      );

      shiftPositionSection.appendChild(shiftPositionElement);
    }
    customElements.get("shift-card-position") ||
      window.customElements.define("shift-card-position", ShiftCardPosition);
  }

  /**
   * @returns {string}
   */
  render() {
    return /*html*/ `
      <style>
        #shift-card {
          background-color: var(--grey-25);
        }
      </style>
    
      <div id="shift-card">
        <div>
          <shift-card-title></shift-card-title>
        </div>
        <div id="shift-position"></div>
        <div>
          <shift-card-button-edit language-code="en"></shift-card-button-edit>
        </div>
      </div>
    `;
  }

  /**
   * @returns {Shift}
   */
  async shift() {
    const shiftId = this.getAttribute("shift-id");
    const apiUrl =
      "/api/calendars/" +
      this.getAttribute("calendar-id") +
      "/shifts/" +
      shiftId;
    const response = await fetch(apiUrl, {
      method: "GET",
      headers: { "Content-Type": "application/json" },
    });

    if (response.status !== 200) {
      throw new Error("Cannot read shift from api [shiftId: " + shiftId + "]");
    }

    return await response.json();
  }

  /**
   * @returns {Applications[]}
   */
  async applications() {
    const shiftId = this.getAttribute("shift-id");
    const apiUrl = "/api/shifts/" + shiftId + "/applications";
    const response = await fetch(apiUrl, {
      method: "GET",
      headers: { "Content-Type": "application/json" },
    });

    if (response.status !== 200) {
      throw new Error(
        "Cannot read shift applications from api [shiftId: " + shiftId + "]"
      );
    }

    return await response.json();
  }
}

"use strict";

import "./shift-card-position.js";
import "./shift-card-title.js";
import "./shift-card-button-edit.js";
import { FrontierElement } from "../frontier-element.js";

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
  static observedAttributes = [
    "lang",
    "shift-start",
    "shift-color",
    "shift-positions",
    "minutes-per-shift",
    "publisher-limit ",
    "route-name",
    "logged-in-publisher-id",
  ];

  constructor() {
    super();
  }

  /**
   * @returns {string}
   */
  async template() {
    const shiftStart = this.getAttribute("shift-start");
    const routeName = this.getAttribute("route-name");
    const lang = this.getAttribute("lang");

    return /*html*/ `
      <style>
        article {
          background-color: var(--grey-25);
        }
      </style>
    
      <article>
        <header>
          <shift-card-title date="${shiftStart}" route-name="${routeName}"></shift-card-title>
        </header>
        ${await this.templateShiftPosition()}
        <footer>
          <shift-card-button-edit lang="${lang}"></shift-card-button-edit>
        </footer>
      </article>
    `;
  }

  /**
   * @returns {string}
   */
  async templateShiftPosition() {
    const minutesPerShift = this.getAttribute("minutes-per-shift");
    const shiftPositions = this.getAttribute("shift-positions");
    const publisherLimit = this.getAttribute("publisher-limit");
    const lang = this.getAttribute("lang");
    const calendarId = this.getAttribute("calendar-id");
    const shiftId = this.getAttribute("shift-id");
    const loggedInPublisherId = this.getAttribute("logged-in-publisher-id");
    const applications = await this.applicationsJson();
    let shiftTo = new Date(this.getAttribute("shift-start"));
    let template = "";

    for (let position = 1; position <= shiftPositions; position++) {
      const applicationsWithPosition = applications.filter(
        (application) => application.shiftPosition === position
      );

      let shiftFrom = new Date(shiftTo);
      shiftTo = new Date(shiftFrom);
      shiftTo.setMinutes(shiftTo.getMinutes() + minutesPerShift);

      const publishers = [];
      for (let column = 0; column < publisherLimit; column++) {
        const application = applicationsWithPosition[column];
        if (application === undefined) {
          publishers.push({});
          continue;
        }
        publishers.push({
          id: applicationsWithPosition[column].publisher.id,
          name: `${applicationsWithPosition[column].publisher.firstname} ${applicationsWithPosition[column].publisher.lastname}`,
        });
      }

      template += /*html*/ `<shift-card-position
          lang="${lang}"
          shift-id="${shiftId}"
          calendar-id="${calendarId}"
          shift-position="${position}"
          shift-from="${shiftFrom.toISOString()}"
          shift-to="${shiftTo.toISOString()}"
          logged-in-publisher-id="${loggedInPublisherId}"
          publishers='${JSON.stringify(publishers)}'>
        </shift-card-position>`;
    }
    return template;
  }

  /**
   * @returns {Promise<Applications[]>}
   */
  async applicationsJson() {
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

window.customElements.define("shift-card", ShiftCard);

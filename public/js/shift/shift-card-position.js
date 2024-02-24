"use strict";

import "./shift-card-time.js";
import "./shift-card-button-publisher-action.js";
import "./shift-card-button-publisher-contact.js";
import "./shift-card-button-available.js";
import { FrontierElement } from "../frontier-element.js";

export class ShiftCardPosition extends FrontierElement {
  static observedAttributes = [
    "publishers",
    "shift-id",
    "calendar-id",
    "shift-position",
    "shift-from",
    "shift-to",
    "logged-in-publisher-id",
    "lang",
  ];

  constructor() {
    super();
  }

  /**
   * @returns {string}
   */
  template() {
    const publishers = JSON.parse(this.getAttribute("publishers"));
    const lang = this.getAttribute("lang");
    const shiftFrom = this.getAttribute("shift-from");
    const shiftTo = this.getAttribute("shift-to");

    return /*html*/ `
      <dl>          
        <dt>
          <shift-card-time lang="${lang}" date-from="${shiftFrom}" date-to="${shiftTo}"></shift-card-time>
        </dt>
        <dd>
          ${this.templateButtons(publishers)}
        </dd>
      </dl>
    `;
  }

  /**
   * @returns {string}
   */
  templateButtons(publishers) {
    const lang = this.getAttribute("lang");
    const shiftId = this.getAttribute("shift-id");
    const calendarId = this.getAttribute("calendar-id");
    const shiftPosition = this.getAttribute("shift-position");
    const loggedInPublisherId = Number(
      this.getAttribute("logged-in-publisher-id")
    );

    return publishers
      .map((publisher) => {
        if (!publisher.id || !publisher.name) {
          return /*html*/ `<shift-card-button-available
            lang="${lang}"
            calendar-id="${calendarId}"
            shift-id="${shiftId}"
            shift-position="${shiftPosition}"
            publisher-id="${loggedInPublisherId}">
          </shift-card-button-available>`;
        }

        if (publisher.id === loggedInPublisherId) {
          return /*html*/ `<shift-card-button-publisher-action
            lang="${lang}"
            calendar-id="${calendarId}"
            shift-id="${shiftId}"
            shift-position="${shiftPosition}"
            publisher-id="${publisher.id}"
            publisher-name="${publisher.name}">
          </shift-card-button-publisher-action>`;
        }

        return /*html*/ `<shift-card-button-publisher-contact
            lang="${lang}"
            calendar-id="${calendarId}"
            shift-id="${shiftId}"
            shift-position="${shiftPosition}"
            publisher-id="${publisher.id}"
            publisher-name="${publisher.name}">
          </shift-card-button-publisher-contact>`;
      })
      .join("");
  }
}

window.customElements.define("shift-card-position", ShiftCardPosition);

import { LitElement, html, until, nothing } from "../lit-all.min.js";
import "../components/view-header.js";
import "../components/shift/shift-info-box.js";
import "../components/shift-calender.js";

/**
 * @typedef {Object} Publisher
 * @property {number} id
 * @property {string} firstname
 * @property {string} lastname
 * @property {string} email
 * @property {string} phone
 * @property {string} mobile
 * @property {string} congregation
 * @property {string} language
 * @property {string} publisherNote
 * @property {string} adminNote
 * @property {boolean} active
 * @property {boolean} administrative
 * @property {string} loggedOn - 2024-05-16 21:32:38
 * @property {string} updatedOn - 2024-04-01 18:34:46
 * @property {string} createdOn - 2023-03-26 11:06:14
 * @property {string} routeName
 * @property {string} start
 * @property {number} numberOfShifts
 * @property {number} minutesPerShift
 * @property {string} color
 * @property {Array} shifts
 */

export class ShiftView extends LitElement {
  static properties = {
    calendarId: { type: Number },
  };

  constructor() {
    super();
    this.calendarId = 0;
  }

  render() {
    return html`<view-header>Trolley Schichten</view-header>
      <shift-info-box></shift-info-box>
      ${until(
        fetch("/api/me")
          .then((response) => response.json())
          .then(
            /**
             * @param {Publisher} publisher
             * @returns {string}
             */
            (publisher) => html` <shift-calendar
              calendarid="${this.calendarId}"
              editable="${publisher.administrative || nothing}"
              publisherid="${publisher.id}"
            ></shift-calendar>`
          ),
        html`<span>Loading...</span>`
      )}`;
  }
}
customElements.define("shift-view", ShiftView);

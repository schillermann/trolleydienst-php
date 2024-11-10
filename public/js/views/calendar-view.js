import { LitElement, html, until, nothing } from "../lit-all.min.js";
import { translate } from "../translate.js";
import "../components/view-header.js";
import "../components/calendar-cards/calendar-info-box.js";
import "../components/calender-cards.js";

/**
 * @typedef {Object} Publisher
 * @property {number} id
 * @property {string} firstname
 * @property {string} lastname
 * @property {string} email
 * @property {string} phone
 * @property {string} mobile
 * @property {string} congregation
 * @property {string} languages
 * @property {string} publisherNote
 * @property {string} adminNote
 * @property {boolean} active
 * @property {boolean} admin
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

export class CalendarView extends LitElement {
  static properties = {
    calendarId: { type: Number },
  };

  constructor() {
    super();
    this.calendarId = 0;
  }

  render() {
    return html`<view-header>${translate("Cart Shifts")}</view-header>
      <calendar-info-box calendarid="${this.calendarId}"></calendar-info-box>
      ${until(
        fetch("/api/me")
          .then((response) => response.json())
          .then(
            /**
             * @param {Publisher} publisher
             * @returns {string}
             */
            (publisher) => html` <calendar-cards
              calendarid="${this.calendarId}"
              editable="${publisher.admin || nothing}"
              publisherid="${publisher.id}"
            ></calendar-cards>`
          ),
        html`<span>${translate("Loading")}...</span>`
      )}`;
  }
}
customElements.define("calendar-view", CalendarView);

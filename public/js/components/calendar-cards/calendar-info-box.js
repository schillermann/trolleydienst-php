import { LitElement, css, html, until } from "../../lit-all.min.js";
import { translate } from "../../translate.js";

/**
 * @typedef {Object} Calendar
 * @property {string} label
 * @property {number} publisherLimitPerShift
 * @property {string} info
 * @property {string} updatedOn - 2024-03-12T21:05:44+01:00
 * @property {string} createdOn - 2023-03-26T11:04:45+02:00
 */

export class CalendarInfoBox extends LitElement {
  static styles = css`
    article {
      border: 1px dotted;
      background-color: var(--td-background-content-accent-color);
      padding: 14px;
    }

    @media (prefers-color-scheme: dark) {
      article {
        background-color: #2e2e2e;
      }
    }
  `;

  static properties = {
    calendarId: { type: Number },
  };

  constructor() {
    super();
    this.calendarId = 0;
  }

  render() {
    const calendar = fetch(`/api/calendars/${this.calendarId}`).then(
      (response) => response.json()
    );
    return html`
      <article>
        ${until(
          calendar.then(
            /**
             * @param {Calendar} calendar
             * @returns {string}
             */
            (calendar) => html`<p>${calendar.info}</p>`
          ),
          html`<span>${translate("Loading")}...</span>`
        )}
      </article>
    `;
  }
}
customElements.define("calendar-info-box", CalendarInfoBox);

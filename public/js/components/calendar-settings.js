import { LitElement, css, html, until } from "../lit-all.min.js";
import { translate } from "../translate.js";
import "./calendar-settings/calendar-settings-dialog.js";
import "./view-button.js";

/**
 * @typedef {Object} Calendar
 * @property {number} id
 * @property {string} info
 * @property {string} name
 * @property {number} publishersPerShift
 * @property {number} minutesPerShift
 * @property {string} updatedOn - 2024-03-12T21:05:44+01:00
 * @property {string} createdOn - 2023-03-26T11:04:45+02:00
 */

export class CalendarSettings extends LitElement {
  static styles = css`
    section {
      overflow-x: auto;
    }

    table {
      margin-top: 20px;
      width: 100%;

      th {
        color: #373433;
        background-color: #afa0bf;
        text-align: left;
        padding: 10px;
        font-size: 17px;
      }

      tr:nth-child(even) {
        background-color: var(--td-background);
      }

      td {
        padding: 6px;
      }
    }
  `;

  constructor() {
    super();
  }

  /**
   * @returns {void}
   */
  connectedCallback() {
    super.connectedCallback();
    this.addEventListener("update-calendar-settings", () => {
      this.requestUpdate();
    });
  }

  /**
   * @param {Event} event
   * @returns {void}
   */
  _openDialog(event) {
    /** @type {Element} */
    const dialog = this.renderRoot.querySelector("calendar-settings-dialog");
    dialog.setAttribute("open", "true");
    const calendarId = event.currentTarget.getAttribute("calendar-id");
    if (!calendarId) {
      return;
    }
    dialog.setAttribute("calendarId", calendarId);
  }

  render() {
    return html`
      <link rel="stylesheet" href="css/fontawesome.min.css" />
      <calendar-settings-dialog
        title="${translate("New Calendar")}"
      ></calendar-settings-dialog>
      <nav>
        <view-button type="primary flex" @click="${this._openDialog}">
          <i class="fa-solid fa-plus"></i>
          ${translate("New Calendar")}
        </view-button>
        <calendar-route-filter></calendar-route-filter>
      </nav>
      <section>
        <table>
          <tbody>
            <tr>
              <th>${translate("Name")}</th>
              <th>${translate("Publishers Per Shift")}</th>
              <th>${translate("Info")}</th>
              <th>${translate("Action")}</th>
            </tr>
            ${until(
              fetch("/api/calendars")
                .then((response) => response.json())
                .then(
                  /**
                   * @param {Calendar[]} calendars
                   */
                  (calendars) =>
                    calendars.map(
                      (calendar) => html`<tr>
                        <td>${calendar.name}</td>
                        <td>${calendar.publishersPerShift}</td>
                        <td>${calendar.info}</td>
                        <td>
                          <view-button
                            type="flex"
                            calendar-id="${calendar.id}"
                            @click="${this._openDialog}"
                            ><i class="fa-solid fa-pencil"></i> ${translate(
                              "Edit"
                            )}</view-button
                          >
                        </td>
                      </tr>`
                    )
                ),
              html`<span>${translate("Loading")}...</span>`
            )}
          </tbody>
        </table>
        <section></section>
      </section>
    `;
  }
}
customElements.define("calendar-settings", CalendarSettings);

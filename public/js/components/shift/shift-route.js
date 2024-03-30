import { LitElement, css, html } from "../../lit-all.min.js";
import { translate } from "../../translate.js";
import "../view-button.js";

/**
 * @typedef {Object} Shift
 * @property {string} from
 * @property {string} to
 * @property {ShiftSlot[]} slots
 */

/**
 * @typedef {Object} ShiftSlot
 * @property {number} publisherId
 * @property {string} publisherName
 */

export class ShiftRoute extends LitElement {
  static properties = {
    currentPublisherId: { type: Number },
    routeName: { type: String },
    calendarId: { type: Number },
    routeId: { type: Number },
    date: {
      /**
       * @param {string} value
       * @returns {Date}
       */
      converter(value) {
        return new Date(value);
      },
    },
    shifts: { type: Array },
    editable: { type: Boolean },
  };

  static styles = css`
    table {
      margin-top: 20px;
    }

    th {
      color: #363636;
      background-color: #d5c8e4;
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

    tfoot tr td {
      background-color: #d5c8e4;
    }
  `;

  constructor() {
    super();
    this.currentPublisherId = 0;
    this.routeName = "";
    this.calendarId = 0;
    this.routeId = 0;
    /** @type {Shift[]} */
    this.shifts = [];
    this.date = new Date();
    this.editable = false;
  }

  /**
   * @param {PointerEvent} event
   * @returns {void}
   */
  _clickPublisherContact(event) {
    this.dispatchEvent(
      new CustomEvent("publisher-contact", {
        bubbles: true,
        composed: true,
        detail: {
          publisherId: event.target.getAttribute("publisher-id"),
          editable: event.target.getAttribute("editable"),
        },
      })
    );
  }

  /**
   * @param {PointerEvent} event
   * @returns {void}
   */
  _clickShiftApplication(event) {
    this.dispatchEvent(
      new CustomEvent("shift-application", {
        bubbles: true,
        composed: true,
        detail: {
          calendarId: event.target.getAttribute("calendarId"),
          publisherSelection: event.target.getAttribute("publisherSelection"),
        },
      })
    );
  }

  /**
   * @param {PointerEvent} event
   * @returns {void}
   */
  _clickShiftRoute(event) {
    this.dispatchEvent(
      new CustomEvent("shift-route", {
        bubbles: true,
        composed: true,
        detail: {
          calendarId: event.target.getAttribute("calendarId"),
          routeId: event.target.getAttribute("routeId"),
        },
      })
    );
  }

  /**
   * @returns {string}
   */
  buttonTemplate() {
    if (this.editable) {
      return html`<view-button
        type="flex"
        calendarid="${this.calendarId}"
        routeid="${this.routeId}"
        @click="${this._clickShiftRoute}"
      >
        <i class="fa-solid fa-pencil"></i>
        ${translate("Edit")}
      </view-button>`;
    }
    return "";
  }

  /**
   * @returns {string}
   */
  render() {
    let shiftId = 0;
    return html`
      <link rel="stylesheet" href="css/fontawesome.min.css" />
      <table>
        <thead>
          <tr>
            <th colspan="2">
              ${this.date.toLocaleDateString(undefined, {
                weekday: "short",
                month: "short",
                day: "numeric",
              })}
              - ${this.routeName}
            </th>
          </tr>
        </thead>
        <tbody>
          ${this.shifts.map(
            (shift) => html`
              <tr>
                <td>${shift.from} - ${shift.to}</td>
                <td>
                  ${shift.slots.map((slot) => {
                    if (slot.publisherId === this.currentPublisherId) {
                      return html`<view-button
                        publisher-id="${slot.publisherId}"
                        editable="true"
                        type="active"
                        @click="${this._clickPublisherContact}"
                      >
                        <i class="fa-regular fa-user"></i>
                        ${slot.publisherName}
                      </view-button>`;
                    }
                    if (slot.publisherName) {
                      return html`
                        <view-button
                          publisher-id="${slot.publisherId}"
                          editable="false"
                          type="active"
                          @click="${this._clickPublisherContact}"
                        >
                          <i class="fa fa-info-circle"></i>
                          ${slot.publisherName}
                        </view-button>
                      `;
                    }
                    return html`<view-button
                      calendarid="${this.calendarId}"
                      routeId="${this.routeId}"
                      shift="${shiftId++}"
                      @click="${this._clickShiftApplication}"
                    >
                      <i class="fa-regular fa-pen-to-square"></i>
                      ${translate("Apply")}
                    </view-button>`;
                  })}
                </td>
              </tr>
            `
          )}
        </tbody>

        <tfoot>
          <tr>
            <td colspan="2">${this.buttonTemplate()}</td>
          </tr>
        </tfoot>
      </table>
    `;
  }
}
customElements.define("shift-route", ShiftRoute);

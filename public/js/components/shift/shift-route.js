import { LitElement, css, html, nothing } from "../../lit-all.min.js";
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
 * @property {string} firstname
 * @property {string} lastname
 */

export class ShiftRoute extends LitElement {
  static properties = {
    currentPublisherId: { type: Number },
    routeName: { type: String },
    calendarId: { type: Number },
    routeId: { type: Number },
    color: { type: String },
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
    @keyframes fade-in {
      0% {
        opacity: 0;
      }
      100% {
        opacity: 1;
      }
    }

    table {
      animation-name: fade-in;
      animation-duration: 3s;
      margin-top: 20px;
      width: 100%;
    }

    th {
      color: #363636;
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
  `;

  constructor() {
    super();
    this.currentPublisherId = 0;
    this.routeName = "";
    this.calendarId = 0;
    this.routeId = 0;
    this.color = "#d5c8e4";
    /** @type {Shift[]} */
    this.shifts = [];
    this.date = new Date();
    this.editable = false;
  }

  /**
   * @param {PointerEvent} event
   * @returns {void}
   */
  _clickPublisher(event) {
    this.dispatchEvent(
      new CustomEvent("open-publisher-contact-dialog", {
        bubbles: true,
        composed: true,
        detail: {
          routeId: event.target.getAttribute("route-id"),
          shiftNumber: event.target.getAttribute("shift-number"),
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
  _clickApply(event) {
    this.dispatchEvent(
      new CustomEvent("open-shift-application-dialog", {
        bubbles: true,
        composed: true,
        detail: {
          routeId: event.target.getAttribute("route-id"),
          shiftNumber: event.target.getAttribute("shift-number"),
          publisherSelection: event.target.getAttribute("publisherSelection"),
        },
      })
    );
  }

  /**
   * @param {PointerEvent} event
   * @returns {void}
   */
  _clickEdit(event) {
    this.dispatchEvent(
      new CustomEvent("open-shift-route-dialog", {
        bubbles: true,
        composed: true,
        detail: {
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
        @click="${this._clickEdit}"
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
    let shiftNumber = 0;
    return html`
      <link rel="stylesheet" href="css/fontawesome.min.css" />
      <table>
        <thead>
          <tr>
            <th colspan="2" style="background-color: ${this.color}">
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
          ${this.shifts.map((shift) => {
            shiftNumber++;
            return html`
              <tr>
                <td>${shift.from} - ${shift.to}</td>
                <td>
                  ${shift.slots.map((slot) => {
                    if (slot.publisherId === this.currentPublisherId) {
                      return html`<view-button
                        route-id="${this.routeId}"
                        shift-number="${shiftNumber}"
                        publisher-id="${slot.publisherId}"
                        editable="${this.editable || nothing}"
                        type="active"
                        @click="${this._clickPublisher}"
                      >
                        <i class="fa-regular fa-user"></i>
                        ${slot.firstname} ${slot.lastname}
                      </view-button>`;
                    }
                    if (slot.publisherId) {
                      return html`
                        <view-button
                          route-id="${this.routeId}"
                          shift-number="${shiftNumber}"
                          publisher-id="${slot.publisherId}"
                          type="active"
                          @click="${this._clickPublisher}"
                        >
                          <i class="fa fa-info-circle"></i>
                          ${slot.firstname} ${slot.lastname}
                        </view-button>
                      `;
                    }
                    return html`<view-button
                      route-id="${this.routeId}"
                      shift-number="${shiftNumber}"
                      @click="${this._clickApply}"
                    >
                      <i class="fa-regular fa-pen-to-square"></i>
                      ${translate("Apply")}
                    </view-button>`;
                  })}
                </td>
              </tr>
            `;
          })}
        </tbody>

        <tfoot>
          <tr>
            <td colspan="2" style="background-color: ${this.color}">
              ${this.buttonTemplate()}
            </td>
          </tr>
        </tfoot>
      </table>
    `;
  }
}
customElements.define("shift-route", ShiftRoute);

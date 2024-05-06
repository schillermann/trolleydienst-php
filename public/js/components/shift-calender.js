import { css, LitElement, until, html } from "../lit-all.min.js";
import { translate } from "../translate.js";
import "./shift/shift-route.js";
import "./shift/shift-route-dialog.js";
import "./shift/shift-contact-dialog.js";
import "./shift/shift-application-dialog.js";

/**
 * @typedef {Object} Route
 * @property {number} id
 * @property {string} routeName
 * @property {string} start
 * @property {number} numberOfShifts
 * @property {number} minutesPerShift
 * @property {string} color
 * @property {Array} shifts
 */

export class ShiftCalendar extends LitElement {
  static styles = css`
    nav {
      margin: 20px 0px 20px 0px;
    }
  `;

  static properties = {
    calendarId: { type: Number },
  };

  constructor() {
    super();
  }

  /**
   * @return {void}
   */
  connectedCallback() {
    super.connectedCallback();
    this.addEventListener(
      "open-publisher-contact-dialog",
      this._eventOpenPublisherContactDialog
    );
    this.addEventListener(
      "open-shift-application-dialog",
      this._eventOpenShiftApplicationDialog
    );
    this.addEventListener(
      "open-shift-route-dialog",
      this._eventOpenShiftRouteDialog
    );
    this.addEventListener("update-calendar", this._updateCalendar);
  }

  /**
   * @return {void}
   */
  disconnectedCallback() {
    this.removeEventListener(
      "open-publisher-contact-dialog",
      this._eventOpenPublisherContactDialog
    );
    this.removeEventListener(
      "open-shift-application-dialog",
      this._eventOpenShiftApplicationDialog
    );
    this.removeEventListener(
      "open-shift-route-dialog",
      this._eventOpenShiftRouteDialog
    );
    this.removeEventListener("update-calendar", this._updateCalendar);
    super.disconnectedCallback();
  }

  /**
   * @param {CustomEvent} event
   * @return {void}
   */
  _updateCalendar(event) {
    this.requestUpdate();
  }

  /**
   * @param {CustomEvent} event
   * @return {void}
   */
  _eventOpenPublisherContactDialog(event) {
    /** @type {Element} */
    const dialog = this.renderRoot.querySelector("shift-contact-dialog");
    dialog.setAttribute("open", "true");
    dialog.setAttribute("publisherId", event.detail.publisherId);
    dialog.setAttribute("routeId", event.detail.routeId);
    dialog.setAttribute("shiftNumber", event.detail.shiftNumber);
    if (event.detail.editable === "true") {
      dialog.setAttribute("editable", true);
    } else {
      dialog.removeAttribute("editable");
    }
  }

  /**
   * @param {CustomEvent} event
   * @return {void}
   */
  _eventOpenShiftApplicationDialog(event) {
    /** @type {Element} */
    const dialog = this.renderRoot.querySelector("shift-application-dialog");
    dialog.setAttribute("open", "true");
    dialog.setAttribute("routeId", event.detail.routeId);
    dialog.setAttribute("shiftNumber", event.detail.shiftNumber);
  }

  /**
   * @param {CustomEvent} event
   * @return {void}
   */
  _eventOpenShiftRouteDialog(event) {
    /** @type {Element} */
    const dialog = this.renderRoot.querySelector("shift-route-dialog");
    dialog.setAttribute("open", "true");
    dialog.setAttribute("editable", event.detail.editable);
    dialog.setAttribute("routeId", event.detail.routeId);
  }

  /**
   * @param {PointerEvent} event
   * @return {void}
   */
  _clickNewShift(event) {
    this.dispatchEvent(
      new CustomEvent("open-shift-route-dialog", {
        bubbles: true,
        composed: true,
        detail: {
          routeId: 0,
          editable: false,
        },
      })
    );
  }

  /**
   * @return {string}
   */
  render() {
    /** @type {Promise<Route[]>} */
    const routes = fetch(`/api/calendars/${this.calendarId}/routes`).then(
      (response) => response.json()
    );
    return html`<nav>
        <view-button type="primary flex" @click="${this._clickNewShift}">
          <i class="fa-solid fa-plus"></i>
          ${translate("New Shift")}
        </view-button>
      </nav>
      <shift-application-dialog
        title="${translate("Shift Application")}"
        calendarId="${this.calendarId}"
        publisherid="1"
      ></shift-application-dialog>
      <shift-contact-dialog
        title="${translate("Publisher Contact")}"
        calendarId="${this.calendarId}"
      ></shift-contact-dialog>
      <shift-route-dialog
        title="${translate("Shift Route")}"
        calendarId="${this.calendarId}"
      ></shift-route-dialog>
      ${until(
        routes.then((routes) =>
          routes.map(
            (route) => html` <shift-route
              calendarId="${this.calendarId}"
              routeId="${route.id}"
              currentPublisherId="1"
              routeName="${route.routeName}"
              date="${route.start}"
              shifts="${JSON.stringify(route.shifts)}"
              color="${route.color}"
              editable="true"
            ></shift-route>`
          )
        ),
        html`<span>${translate("Loading")}...</span>`
      )}`;
  }
}
customElements.define("shift-calendar", ShiftCalendar);

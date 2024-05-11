import { css, LitElement, html } from "../lit-all.min.js";
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
    _pageNumber: { type: Number, state: true },
  };

  constructor() {
    super();
    this.calendarId = 0;
    this._pageNumber = 1;
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
    this.addEventListener("update-calendar", this._eventUpdateCalendar);
    window.addEventListener("scroll", this._eventInfiniteScroll.bind(this));
  }

  /**
   * @return {void}
   */
  disconnectedCallback() {
    super.disconnectedCallback();
    window.removeEventListener("scroll", this._eventInfiniteScroll);
  }

  async _eventInfiniteScroll() {
    const scrollPoint = window.innerHeight + window.scrollY;
    const totalPageHeight = document.body.offsetHeight;
    if (scrollPoint >= totalPageHeight) {
      this._pageNumber++;
      await this._updateRoutes();
    }
  }

  /**
   * @param {CustomEvent} event
   * @return {void}
   */
  async _eventUpdateCalendar(event) {
    if (event.detail?.deleteRouteId) {
      this._deleteRoute(event.detail?.deleteRouteId);
    }
    await this._updateRoutes();
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
   * @param {Map} changedProperties
   * @returns {Promise<void>}
   */
  async firstUpdated(changedProperties) {
    await this._updateRoutes();
  }

  /**
   * @param {number} routeId
   * @returns {void}
   */
  _deleteRoute(routeId) {
    const section = this.renderRoot.querySelector("section");
    const route = section.querySelector(`[routeId="${routeId}"]`);
    route.remove();
  }

  /**
   * @returns {Promise<void>}
   */
  async _updateRoutes() {
    const response = await fetch(
      `/api/calendars/${this.calendarId}/routes?page-number=${this._pageNumber}`
    );
    /** @type {Route[]} */
    const routes = await response.json();
    /** @type {Element} */
    const section = this.renderRoot.querySelector("section");

    for (const route of routes) {
      let shiftRoute = section.querySelector(`[routeId="${route.id}"]`);
      if (!shiftRoute) {
        shiftRoute = document.createElement("shift-route");
        section.appendChild(shiftRoute);
      }
      shiftRoute.setAttribute("calendarId", this.calendarId);
      shiftRoute.setAttribute("routeId", route.id);
      shiftRoute.setAttribute("currentPublisherId", 1);
      shiftRoute.setAttribute("routeName", route.routeName);
      shiftRoute.setAttribute("date", route.start);
      shiftRoute.setAttribute("shifts", JSON.stringify(route.shifts));
      shiftRoute.setAttribute("color", route.color);
      shiftRoute.setAttribute("editable", true);
    }
  }

  /**
   * @return {string}
   */
  render() {
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
      <section></section>`;
  }
}
customElements.define("shift-calendar", ShiftCalendar);

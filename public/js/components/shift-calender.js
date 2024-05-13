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
  /** @type {Element} */
  _loadingCircle;

  static styles = css`
    nav {
      margin: 20px 0px 20px 0px;
    }

    section#loading {
      text-align: center;
      padding-top: 20px;
      svg {
        width: 30px;
        height: 30px;
      }
    }
  `;

  static properties = {
    calendarId: { type: Number },
    _pageItems: { type: Number, state: true },
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
      if (await this._loadNextRoutes(this._pageNumber + 1)) {
        this._pageNumber++;
      }
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
    this._loadingCircle = this.renderRoot.querySelector("section#loading svg");
    this._rotationAnimation = this._loadingCircle.animate(
      [{ transform: "rotate(0)" }, { transform: "rotate(360deg)" }],
      {
        duration: 3000,
        iterations: Infinity,
      }
    );

    await this._loadNextRoutes(this._pageNumber);
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
    for (let pageNumber = 1; pageNumber <= this._pageNumber; pageNumber++) {
      await this._loadNextRoutes(pageNumber);
    }
  }

  /**
   * @param {number} pageNumber
   * @returns {boolean} routes have been loaded
   */
  async _loadNextRoutes(pageNumber) {
    this._rotationAnimation.play();
    this._loadingCircle.style.visibility = "visible";

    const response = await fetch(
      `/api/calendars/${this.calendarId}/routes?page-number=${pageNumber}`
    );

    /** @type {Route[]} */
    const routes = await response.json();
    /** @type {Element} */
    const section = this.renderRoot.querySelector("section");

    for (const route of routes) {
      let routeElement = section.querySelector(`[routeId="${route.id}"]`);
      if (!routeElement) {
        routeElement = document.createElement("shift-route");
        section.appendChild(routeElement);
      }
      routeElement.setAttribute("calendarId", this.calendarId);
      routeElement.setAttribute("routeId", route.id);
      routeElement.setAttribute("currentPublisherId", 1);
      routeElement.setAttribute("routeName", route.routeName);
      routeElement.setAttribute("date", route.start);
      routeElement.setAttribute("shifts", JSON.stringify(route.shifts));
      routeElement.setAttribute("color", route.color);
      routeElement.setAttribute("editable", true);
    }
    this._rotationAnimation.pause();
    this._loadingCircle.style.visibility = "hidden";

    return routes.length != 0;
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
      <section></section>
      <section id="loading">
        <svg
          aria-hidden="true"
          focusable="false"
          role="presentation"
          class="icon icon-spinner"
          viewBox="0 0 20 20"
        >
          <path
            d="M7.229 1.173a9.25 9.25 0 1 0 11.655 11.412 1.25 1.25 0 1 0-2.4-.698 6.75 6.75 0 1 1-8.506-8.329 1.25 1.25 0 1 0-.75-2.385z"
            fill="#919EAB"
          />
        </svg>
      </section>`;
  }
}
customElements.define("shift-calendar", ShiftCalendar);

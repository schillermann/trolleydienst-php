import { css, LitElement, html, nothing } from "../lit-all.min.js";
import { translate } from "../translate.js";
import "./shift/shift-application-dialog.js";
import "./shift/shift-contact-dialog.js";
import "./shift/shift-route.js";
import "./shift/shift-route-dialog.js";
import "./shift/shift-route-filter.js";

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
  /** @type {number} */
  _pageNumber;
  /** @type {Date} */
  _routesFrom;

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
    publisherId: { type: Number },
    editable: { type: Boolean },
  };

  constructor() {
    super();
    this.calendarId = 0;
    this.publisherId = 0;
    this.editable = false;
    this._pageNumber = 1;
    this._routesFrom = new Date();
  }

  /**
   * @returns {void}
   */
  connectedCallback() {
    super.connectedCallback();
    this.addEventListener(
      "open-shift-contact-dialog",
      this._handleOpenPublisherContactDialog
    );
    this.addEventListener(
      "open-shift-application-dialog",
      this._handleOpenShiftApplicationDialog
    );
    this.addEventListener(
      "open-shift-route-dialog",
      this._handleOpenShiftRouteDialog
    );
    this.addEventListener("update-calendar", this._handleUpdateCalendar);
    this.addEventListener("filter-routes", this._handlerFilterRoutes);
    window.addEventListener("scroll", this._handleInfiniteScroll.bind(this));
  }

  /**
   * @returns {void}
   */
  disconnectedCallback() {
    super.disconnectedCallback();
    window.removeEventListener("scroll", this._handleInfiniteScroll);
  }

  async _handleInfiniteScroll() {
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
   * @returns {void}
   */
  async _handleUpdateCalendar(event) {
    if (event.detail?.deleteRouteId) {
      this._deleteRoute(event.detail?.deleteRouteId);
    }
    await this._updateRoutes();
  }

  /**
   * @param {CustomEvent} event
   * @returns {void}
   */
  _handleOpenPublisherContactDialog(event) {
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
   * @returns {void}
   */
  _handleOpenShiftApplicationDialog(event) {
    /** @type {Element} */
    const dialog = this.renderRoot.querySelector("shift-application-dialog");
    dialog.setAttribute("open", "true");
    dialog.setAttribute("routeId", event.detail.routeId);
    dialog.setAttribute("shiftNumber", event.detail.shiftNumber);
    dialog.setAttribute("publisherId", this.publisherId);
  }

  /**
   * @param {CustomEvent} event
   * @returns {void}
   */
  _handleOpenShiftRouteDialog(event) {
    /** @type {Element} */
    const dialog = this.renderRoot.querySelector("shift-route-dialog");
    dialog.setAttribute("open", "true");
    if (event.detail.editable) {
      dialog.setAttribute("editable", true);
    } else {
      dialog.removeAttribute("editable");
    }

    dialog.setAttribute("routeId", event.detail.routeId);
  }

  /**
   * @param {Event} event
   * @returns {void}
   */
  _handlerFilterRoutes(event) {
    this._routesFrom = event.detail.dateFrom;
    const routesSection = this.renderRoot.getElementById("routes");
    routesSection.replaceChildren();
    this._loadNextRoutes(1);
  }

  /**
   * @param {PointerEvent} event
   * @returns {void}
   */
  _onClickNewShift(event) {
    this.dispatchEvent(
      new CustomEvent("open-shift-route-dialog", {
        bubbles: true,
        composed: true,
        detail: {
          routeId: 0,
          editable: this.editable,
        },
      })
    );
  }

  /**
   * @param {Map} changedProperties
   * @returns {Promise<void>}
   */
  async firstUpdated(changedProperties) {
    this._loadingCircle = this.renderRoot.querySelector("#loading svg");
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
    const routesSection = this.renderRoot.getElementById("routes");
    const route = routesSection.querySelector(`[routeId="${routeId}"]`);
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

    const startDate = this._routesFrom.toISOString().split("T")[0];
    const response = await fetch(
      `/api/calendars/${this.calendarId}/routes?page-number=${pageNumber}&start-date=${startDate}`
    );

    /** @type {Route[]} */
    const routes = await response.json();
    /** @type {Element} */
    const routesSection = this.renderRoot.getElementById("routes");

    for (const route of routes) {
      let routeElement = routesSection.querySelector(`[routeId="${route.id}"]`);
      if (!routeElement) {
        routeElement = document.createElement("shift-route");
        routesSection.appendChild(routeElement);
      }
      routeElement.setAttribute("calendarId", this.calendarId);
      routeElement.setAttribute("routeId", route.id);
      routeElement.setAttribute("publisherId", this.publisherId);
      routeElement.setAttribute("routeName", route.routeName);
      routeElement.setAttribute("date", route.start);
      routeElement.setAttribute("shifts", JSON.stringify(route.shifts));
      routeElement.setAttribute("color", route.color);
      if (this.editable) {
        routeElement.setAttribute("editable", true);
      } else {
        routeElement.removeAttribute("editable");
      }
    }
    this._rotationAnimation.pause();
    this._loadingCircle.style.visibility = "hidden";

    return routes.length != 0;
  }

  /**
   * @returns {string}
   */
  render() {
    return html`<nav>
        <view-button type="primary flex" @click="${this._onClickNewShift}">
          <i class="fa-solid fa-plus"></i>
          ${translate("New Shift")}
        </view-button>
      </nav>
      <shift-application-dialog
        title="${translate("Shift Application")}"
        calendarId="${this.calendarId}"
        selectable="${this.editable || nothing}"
      ></shift-application-dialog>
      <shift-contact-dialog
        title="${translate("Publisher Contact")}"
        calendarId="${this.calendarId}"
      ></shift-contact-dialog>
      <shift-route-dialog
        title="${translate("Shift Route")}"
        calendarId="${this.calendarId}"
      ></shift-route-dialog>
      <shift-route-filter></shift-route-filter>

      <section id="routes"></section>
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

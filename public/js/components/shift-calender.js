import { LitElement, until, html } from "../lit-all.min.js";
import { translate } from "../translate.js";
import "./shift/shift-route.js";
import "./shift/shift-route-dialog.js";
import "./shift/shift-contact-dialog.js";
import "./shift/shift-application-dialog.js";

export class ShiftCalendar extends LitElement {
  static properties = {
    calendarId: { type: Number },
  };

  constructor() {
    super();
  }

  connectedCallback() {
    super.connectedCallback();
    this.addEventListener("publisher-contact", this._eventPublisherContact);
    this.addEventListener("shift-application", this._eventShiftApplication);
    this.addEventListener("shift-route", this._eventShiftRoute);
  }

  disconnectedCallback() {
    this.removeEventListener("publisher-contact", this._eventPublisherContact);
    this.removeEventListener("shift-application", this._eventShiftApplication);
    this.removeEventListener("shift-route", this._eventShiftRoute);
    super.disconnectedCallback();
  }

  /**
   * @param {CustomEvent} event
   */
  _eventPublisherContact(event) {
    /** @type {Element} */
    const dialog = this.renderRoot.querySelector("shift-contact-dialog");
    dialog.setAttribute("open", "true");
    dialog.setAttribute("publisherId", event.detail.publisherId);
    if (event.detail.editable === "true") {
      dialog.setAttribute("editable", true);
    } else {
      dialog.removeAttribute("editable");
    }
  }

  /**
   * @param {CustomEvent} event
   */
  _eventShiftApplication(event) {
    /** @type {Element} */
    const dialog = this.renderRoot.querySelector("shift-application-dialog");
    dialog.setAttribute("open", "true");
    dialog.setAttribute("calendarId", event.detail.calendarId);
  }

  /**
   * @param {CustomEvent} event
   */
  _eventShiftRoute(event) {
    /** @type {Element} */
    const dialog = this.renderRoot.querySelector("shift-route-dialog");
    dialog.setAttribute("open", "true");
    dialog.setAttribute("calendarId", event.detail.calendarId);
    dialog.setAttribute("routeId", event.detail.routeId);
  }

  render() {
    const routes = fetch(`/api/calendars/${this.calendarId}/routes.json`).then(
      (response) => response.json()
    );
    return html`<shift-application-dialog
        defaultpublisherid="1"
        title="${translate("Shift Application")}"
      ></shift-application-dialog>
      <shift-contact-dialog
        title="${translate("Publisher Contact")}"
      ></shift-contact-dialog>
      <shift-route-dialog
        title="${translate("Shift Route")}"
      ></shift-route-dialog>
      ${until(
        routes.then((routes) =>
          routes.map(
            (route) => html` <shift-route
              calendarId="${this.calendarId}"
              routeId="${route.id}"
              currentPublisherId="1"
              routeName="${route.routeName}"
              date="${route.date}"
              shifts="${JSON.stringify(route.shifts)}"
              editable="true"
            ></shift-route>`
          )
        ),
        html`<span>${translate("Loading")}...</span>`
      )}`;
  }
}
customElements.define("shift-calendar", ShiftCalendar);

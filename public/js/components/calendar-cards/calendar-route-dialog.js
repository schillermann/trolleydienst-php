import { html, until } from "../../lit-all.min.js";
import { ViewDialog } from "../view-dialog.js";
import { translate } from "../../translate.js";

/**
 * @typedef {Object} Route
 * @property {number} id
 * @property {string} routeName
 * @property {string} start - 2024-05-01T09:00:00+02:00
 * @property {number} numberOfShifts
 * @property {number} minutesPerShift
 * @property {string} color - #d5c8e4
 * @property {string}updatedOn - 2024-03-12T20:42:09+01:00
 * @property {string}createdOn - 2024-03-12T20:42:09+01:00
 */

export class CalendarRouteDialog extends ViewDialog {
  static properties = {
    calendarId: { type: Number },
    routeId: { type: Number },
  };
  constructor() {
    super();
    this.calendarId = 0;
    this.routeId = 0;
  }

  /**
   * @param {Event} event
   */
  _changeShiftTime(event) {
    const timeFrom = this.renderRoot.getElementById("from").value;
    if (!timeFrom) {
      return;
    }
    const timeFromSplit = timeFrom.split(":");
    const dateFrom = new Date();
    dateFrom.setHours(timeFromSplit[0]);
    dateFrom.setMinutes(timeFromSplit[1]);

    const dateTo = new Date(dateFrom);
    const numberOfShifts =
      this.renderRoot.getElementById("number-of-shifts").value;
    const minutesPerShift =
      this.renderRoot.getElementById("minutes-per-shift").value;

    dateTo.setMinutes(dateTo.getMinutes() + numberOfShifts * minutesPerShift);
    dateTo.setSeconds(0);
    this.renderRoot.getElementById("to").value = dateTo
      .toTimeString()
      .slice(0, 8);
  }

  /**
   * @param {SubmitEvent} event
   * @returns {void}
   */
  async _editRoute(event) {
    event.preventDefault();
    /** @type {HTMLFormControlsCollection} */
    const elements = event.currentTarget.elements;
    const response = await fetch(
      `/api/calendars/${this.calendarId}/routes/${this.routeId}`,
      {
        method: "PUT",
        body: JSON.stringify({
          routeName: elements["route-name"].value,
          start: new Date(
            elements["date"].value + " " + elements["from"].value
          ).toLocaleString(),
          numberOfShifts: Number(elements["number-of-shifts"].value),
          minutesPerShift: Number(elements["minutes-per-shift"].value),
          color: elements["color"].value,
        }),
      }
    );

    if (response.ok) {
      this.dispatchEvent(
        new Event("update-calendar", {
          bubbles: true,
          composed: true,
        })
      );
      this.open = false;
      return;
    }

    console.error({
      statusCode: response.status,
      statusText: response.statusText,
    });
    this._errorMessage = translate("Route change could not be saved.");
  }

  /**
   * @param {SubmitEvent} event
   * @returns {void}
   */
  async _createRoute(event) {
    event.preventDefault();
    /** @type {HTMLFormControlsCollection} */
    const elements = event.currentTarget.elements;

    const start = new Date(
      elements["date"].value + " " + elements["from"].value
    );
    const until = elements["shift-series-until"].value;
    const shiftSeriesUntil = until ? new Date(until) : new Date(start);
    shiftSeriesUntil.setDate(shiftSeriesUntil.getDate() + 1);

    do {
      const response = await fetch(`/api/calendars/${this.calendarId}/routes`, {
        method: "POST",
        body: JSON.stringify({
          routeName: elements["route-name"].value,
          start: start.toLocaleString(),
          numberOfShifts: Number(elements["number-of-shifts"].value),
          minutesPerShift: Number(elements["minutes-per-shift"].value),
          color: elements["color"].value,
        }),
      });
      if (!response.ok) {
        console.error({
          statusCode: response.status,
          statusText: response.statusText,
        });
        this._errorMessage = translate("Route could not be created.");
        return;
      }
    } while (start.setDate(start.getDate() + 7) <= shiftSeriesUntil.getTime());

    this.dispatchEvent(
      new Event("update-calendar", {
        bubbles: true,
        composed: true,
      })
    );
    this.open = false;
  }

  /**
   * @param {Event} event
   * @returns {void}
   */
  async _clickDelete(event) {
    const response = await fetch(
      `/api/calendars/${this.calendarId}/routes/${this.routeId}`,
      {
        method: "DELETE",
      }
    );

    if (response.ok) {
      this.dispatchEvent(
        new CustomEvent("update-calendar", {
          bubbles: true,
          composed: true,
          detail: {
            deleteRouteId: this.routeId,
          },
        })
      );
      this.routeId = 0;
      this.open = false;
      return;
    }

    console.error({
      statusCode: response.status,
      statusText: response.statusText,
    });
    this._errorMessage = translate("Route could not be deleted.");
  }

  /**
   * @returns {string}
   */
  _shiftSeriesTemplate() {
    if (this.routeId) {
      return "";
    }

    return html`<dt>
        <label for="shift-series-until"
          >${translate("Shift series until")}:</label
        >
      </dt>
      <dd>
        <input type="date" id="shift-series-until" name="shift-series-until" />
      </dd>`;
  }

  /**
   * @returns {string}
   */
  _buttonDeleteTemplate() {
    if (this.routeId) {
      return html`<view-button type="danger wide" @click="${this._clickDelete}">
        <i class="fa-regular fa-trash-o"></i>
        ${translate("Delete")}
      </view-button>`;
    }

    return "";
  }

  /**
   * @returns {string}
   */
  contentTemplate() {
    const route = this.routeId
      ? fetch(`/api/calendars/${this.calendarId}/routes/${this.routeId}`).then(
          (response) => response.json()
        )
      : Promise.resolve().then(() => {
          const start = new Date();
          start.setHours(8);
          start.setSeconds(0);
          start.setMinutes(0);
          return {
            routeName: "",
            start: start.toString(),
            numberOfShifts: 1,
            minutesPerShift: 60,
            color: "#604A7B",
            updatedOn: new Date().toLocaleString(),
            createdOn: new Date().toLocaleString(),
          };
        });

    return until(
      route.then(
        /** @param {Route} route */
        (route) => {
          const dateFrom = new Date(route.start);
          const dateTo = new Date(dateFrom);
          dateTo.setMinutes(
            dateTo.getMinutes() + route.numberOfShifts * route.minutesPerShift
          );
          return html`
            <link rel="stylesheet" href="css/fontawesome.min.css" />
            <p>${this._errorMessage}</p>
            <form
              @submit=${(event) =>
                this.routeId
                  ? this._editRoute(event)
                  : this._createRoute(event)}
            >
              <dl>
                <dt>
                  <label for="route-name">${translate("Route Name")}:</label>
                </dt>
                <dd>
                  <input
                    type="text"
                    id="route-name"
                    name="route-name"
                    value="${route.routeName}"
                    required
                  />
                </dd>

                <dt>
                  <label for="date">${translate("Date")}:</label>
                </dt>
                <dd>
                  <input
                    type="date"
                    id="date"
                    name="date"
                    value="${dateFrom.toISOString().slice(0, 10)}"
                  />
                </dd>

                <dt>
                  <label for="from">${translate("From")}:</label>
                </dt>
                <dd>
                  <input
                    type="time"
                    id="from"
                    name="from"
                    value="${dateFrom.toTimeString().slice(0, 8)}"
                    @change="${this._changeShiftTime}"
                  />
                </dd>

                <dt>
                  <label for="number-of-shifts"
                    >${translate("Number Of Shifts")}:</label
                  >
                </dt>
                <dd>
                  <input
                    type="number"
                    id="number-of-shifts"
                    name="number-of-shifts"
                    value="${route.numberOfShifts}"
                    @change="${this._changeShiftTime}"
                  />
                </dd>

                <dt>
                  <label for="minutes-per-shift"
                    >${translate("Minutes Per Shift")}:</label
                  >
                </dt>
                <dd>
                  <input
                    type="number"
                    id="minutes-per-shift"
                    name="minutes-per-shift"
                    value="${route.minutesPerShift}"
                    @change="${this._changeShiftTime}"
                  />
                </dd>

                <dt><label for="to">${translate("To")}:</label></dt>
                <dd>
                  <input
                    type="time"
                    id="to"
                    name="to"
                    value="${dateTo.toTimeString().slice(0, 8)}"
                    disabled
                  />
                </dd>

                <dt><label for="color">${translate("Color")}:</label></dt>
                <dd>
                  <input
                    type="color"
                    id="color"
                    name="color"
                    value="${route.color}"
                  />
                </dd>
                ${this._shiftSeriesTemplate()}
              </dl>
              ${this._buttonDeleteTemplate()}
              <view-button
                type="primary wide"
                @click="${(e) =>
                  this.renderRoot.querySelector("form").requestSubmit()}"
              >
                <i class="fa-regular fa-floppy-disk"></i>
                ${translate("Save")}
              </view-button>
            </form>
          `;
        }
      ),
      html`<span>${translate("Loading")}...</span>`
    );
  }
}
customElements.define("calendar-route-dialog", CalendarRouteDialog);

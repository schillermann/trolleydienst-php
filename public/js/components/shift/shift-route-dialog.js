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

export class ShiftRouteDialog extends ViewDialog {
  static properties = {
    _responseStatusCode: { type: Number, state: true },
    calendarId: { type: Number },
    routeId: { type: Number },
  };
  constructor() {
    super();
    this._responseStatusCode = 0;
    this.calendarId = 0;
    this.routeId = 0;
  }

  /**
   * @param {Event} event
   */
  _changeShiftTime(event) {
    const timeFrom = this.renderRoot.getElementById("from").value;
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
    this.renderRoot.getElementById("to").value = dateTo.toLocaleTimeString();
  }

  /**
   * @returns {string}
   */
  errorTemplate() {
    switch (this._responseStatusCode) {
      case 0:
        return "";
      default:
        return translate("Route change could not be saved");
    }
  }

  /**
   * @param {SubmitEvent} event
   * @returns {void}
   */
  async _submitForm(event) {
    event.preventDefault();
    /** @type {HTMLFormControlsCollection} */
    const elements = event.currentTarget.elements;
    const response = await fetch(
      `/api/calendars/${this.calendarId}/routes/${this.routeId}`,
      {
        method: "PATCH",
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
        new CustomEvent("update-calendar", {
          bubbles: true,
          cancelable: false,
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
    this._responseStatusCode = response.status;
  }

  /**
   * @returns {string}
   */
  contentTemplate() {
    const route = this.routeId
      ? fetch(`/api/calendars/${this.calendarId}/routes/${this.routeId}`).then(
          (response) => response.json()
        )
      : Promise.resolve({
          date: new Date(),
        });

    return until(
      route.then(
        /** @param {Route} route */
        (route) => {
          if (!route.start) {
            route.start = new Date();
          }
          const dateFrom = new Date(route.start);
          const dateTo = new Date(dateFrom);
          dateTo.setMinutes(
            dateTo.getMinutes() + route.numberOfShifts * route.minutesPerShift
          );
          return html`
            <link rel="stylesheet" href="css/fontawesome.min.css" />
            <p>${this.errorTemplate()}</p>
            <form @submit=${this._submitForm}>
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
              </dl>
              <button type="submit">
                <i class="fa-regular fa-floppy-disk"></i>
                ${translate("Save")}
              </button>
            </form>
          `;
        }
      ),
      html`<span>${translate("Loading")}...</span>`
    );
  }
}
customElements.define("shift-route-dialog", ShiftRouteDialog);

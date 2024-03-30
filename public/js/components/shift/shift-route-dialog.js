import { html, until } from "../../lit-all.min.js";
import { ViewDialog } from "../view-dialog.js";
import { translate } from "../../translate.js";

export class ShiftRouteDialog extends ViewDialog {
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
   * @param {Event} event
   */
  _clickSave(event) {
    console.log("TODO: save shift changes");
    this.open = false;
  }

  /**
   * @returns {string}
   */
  contentTemplate() {
    const route = this.routeId
      ? fetch(
          `/api/calendars/${this.calendarId}/routes/${this.routeId}.json`
        ).then((response) => response.json())
      : Promise.resolve({
          date: new Date(),
        });

    return until(
      route.then((r) => {
        const dateFrom = new Date(r.date);
        const dateTo = new Date(dateFrom);
        dateTo.setMinutes(
          dateTo.getMinutes() + r.numberOfShifts * r.minutesPerShift
        );
        return html`
          <link rel="stylesheet" href="css/fontawesome.min.css" />
          <form>
            <dl>
              <dt>
                <label for="route-name">${translate("Route Name")}:</label>
              </dt>
              <dd>
                <input
                  type="text"
                  id="route-name"
                  name="route-name"
                  value="${r.routeName}"
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
                  value="${r.numberOfShifts}"
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
                  value="${r.minutesPerShift}"
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
                  value="${r.color}"
                />
              </dd>
            </dl>
            <view-button type="primary wide" @click="${this._clickSave}">
              <i class="fa-regular fa-floppy-disk"></i>
              ${translate("Save")}
            </view-button>
          </form>
        `;
      }),
      html`<span>${translate("Loading")}...</span>`
    );
  }
}
customElements.define("shift-route-dialog", ShiftRouteDialog);

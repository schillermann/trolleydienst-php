import { html, css, until } from "../lit-all.min.js";
import { ViewDialog } from "./view-dialog.js";
import { translate } from "../translate.js";

/**
 * @typedef {Object} Calendar
 * @property {string} name
 * @property {number} publishersPerShift
 * @property {string} info
 * @property {string} updatedOn - 2024-03-12T21:05:44+01:00
 * @property {string} createdOn - 2023-03-26T11:04:45+02:00
 */

export class CalendarSettingsDialog extends ViewDialog {
  static properties = {
    calendarId: { type: Number },
  };

  static styles = [
    ViewDialog.styles,
    css`
      textarea {
        height: 4em;
        width: 20em;
      }
    `,
  ];

  constructor() {
    super();
    this._closed();
  }

  _closed() {
    this.calendarId = 0;
  }

  /**
   * @param {SubmitEvent} event
   * @returns {void}
   */
  async _editCalendar(event) {
    event.preventDefault();
    /** @type {HTMLFormControlsCollection} */
    const elements = event.currentTarget.elements;
    const response = await fetch(`/api/calendars/${this.calendarId}`, {
      method: "PUT",
      body: JSON.stringify({
        name: elements["calendar-name"].value,
        publishersPerShift: Number(elements["publishers-per-shift"].value),
        info: elements["info"].value,
      }),
    });

    if (response.ok) {
      this.dispatchEvent(
        new Event("update-calendar-settings", {
          bubbles: true,
          composed: true,
        })
      );
      this.open = false;
      this.calendarId = 0;
      return;
    }

    console.error({
      statusCode: response.status,
      statusText: response.statusText,
    });
    this._errorMessage = translate("Calendar could not be saved.");
  }

  /**
   * @param {SubmitEvent} event
   * @returns {void}
   */
  async _createCalendar(event) {
    event.preventDefault();
    /** @type {HTMLFormControlsCollection} */
    const elements = event.currentTarget.elements;

    const response = await fetch(`/api/calendars`, {
      method: "POST",
      body: JSON.stringify({
        name: elements["calendar-name"].value,
        info: elements["info"].value,
        publishersPerShift: Number(elements["publishers-per-shift"].value),
      }),
    });
    if (!response.ok) {
      console.error({
        statusCode: response.status,
        statusText: response.statusText,
      });
      this._errorMessage = translate("Calendar could not be created.");
      return;
    }

    this.dispatchEvent(
      new Event("update-calendar-settings", {
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
    const response = await fetch(`/api/calendars/${this.calendarId}`, {
      method: "DELETE",
    });

    if (response.ok) {
      this.dispatchEvent(
        new Event("update-calendar-settings", {
          bubbles: true,
          composed: true,
        })
      );
      this.calendarId = 0;
      this.open = false;
      return;
    }

    console.error({
      statusCode: response.status,
      statusText: response.statusText,
    });
    this._errorMessage = translate("Calendar could not be deleted.");
  }

  /**
   * @returns {string}
   */
  _buttonDeleteTemplate() {
    if (this.calendarId === 0) {
      return "";
    }
    return html`<view-button type="danger wide" @click="${this._clickDelete}">
      <i class="fa-regular fa-trash-o"></i>
      ${translate("Delete")}
    </view-button>`;
  }

  /**
   * @returns {string}
   */
  contentTemplate() {
    /** @type {Calendar} */
    const calendarResponse = this.calendarId
      ? fetch(`/api/calendars/${this.calendarId}`).then((response) =>
          response.json()
        )
      : Promise.resolve().then(() => {
          return {
            name: "",
            publishersPerShift: 4,
            info: "",
            updatedOn: new Date().toLocaleString(),
            createdOn: new Date().toLocaleString(),
          };
        });

    return html`
      <link rel="stylesheet" href="css/fontawesome.min.css" />
      <p>${this._errorMessage}</p>
      <form
        @submit=${(event) =>
          this.calendarId
            ? this._editCalendar(event)
            : this._createCalendar(event)}
      >
        ${until(
          calendarResponse.then(
            (calendar) => html`<dl>
              <dt>
                <label for="calender-name">${translate("Name")}:</label>
              </dt>
              <dd>
                <input
                  type="text"
                  id="calendar-name"
                  name="calendar-name"
                  value="${calendar.name}"
                  required
                />
              </dd>

              <dt>
                <label for="publishers-per-shift"
                  >${translate("Publishers Per Shift")}:</label
                >
              </dt>
              <dd>
                <input
                  type="number"
                  id="publishers-per-shift"
                  name="publishers-per-shift"
                  value="${calendar.publishersPerShift}"
                  required
                />
              </dd>

              <dt>
                <label for="info">${translate("Info")}:</label>
              </dt>
              <dd>
                <textarea id="info" name="info">${calendar.info}</textarea>
              </dd>
            </dl>`
          ),
          html`<span>${translate("Loading")}...</span>`
        )}
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
}
customElements.define("calendar-settings-dialog", CalendarSettingsDialog);

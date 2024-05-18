import { html, until } from "../../lit-all.min.js";
import { translate } from "../../translate.js";
import { ViewDialog } from "../view-dialog.js";

export class ShiftContactDialog extends ViewDialog {
  static properties = {
    calendarId: { type: Number },
    routeId: { type: Number },
    shiftNumber: { type: Number },
    publisherId: { type: Number },
    editable: { type: Boolean },
    _isError: { type: Boolean, state: true },
  };

  constructor() {
    super();
    this.calendarId = 0;
    this.routeId = 0;
    this.shiftNumber = 0;
    this.publisherId = 0;
    this.editable = false;
    this._isError = false;
  }

  /**
   * @param {Event} event
   */
  async _clickDelete(event) {
    const response = await fetch(
      `/api/calendars/${this.calendarId}/routes/${this.routeId}/shifts/${this.shiftNumber}/publishers/${this.publisherId}`,
      {
        method: "DELETE",
      }
    );

    if (response.ok) {
      this.open = false;
      this.dispatchEvent(
        new Event("update-calendar", {
          bubbles: true,
          composed: true,
        })
      );
      return;
    }

    this._isError = true;
    console.error({
      httpResponseStatus: {
        code: response.status,
        message: response.statusText,
      },
    });
  }

  /**
   * @returns {string}
   */
  buttonTemplate() {
    if (this.editable) {
      return html` <view-button
        type="danger wide"
        @click="${this._clickDelete}"
      >
        <i class="fa fa-times-circle"></i>
        ${translate("Delete")}
      </view-button>`;
    }
    return "";
  }

  /**
   * @returns {string}
   */
  contentTemplate() {
    const publisher = this.publisherId
      ? fetch("/api/publishers/" + this.publisherId).then((response) =>
          response.json()
        )
      : Promise.resolve({});

    return until(
      publisher.then(
        (p) => html`<p>
            ${this._isError
              ? translate("Shift entry could not be deleted.")
              : ""}
          </p>
          <h3>${p.firstname} ${p.lastname}</h3>
          <link rel="stylesheet" href="css/fontawesome.min.css" />
          <address>
            <dl>
              <dt>${translate("Email")}:</dt>
              <dd>
                <a href="mailto:${p.email}">${p.email}</a>
              </dd>
              <dt>${translate("Phone")}:</dt>
              <dd><a href="tel:${p.phone}">${p.phone}</a></dd>
              <dt>${translate("Mobile")}:</dt>
              <dd><a href="tel:${p.mobile}">${p.mobile}</a></dd>
            </dl>
          </address>
          <h4>${translate("Info From Publisher")}:</h4>
          <p>${p.publisherNote}</p>
          ${this.buttonTemplate()}`
      ),
      html`<span>${translate("Loading")}...</span>`
    );
  }
}
customElements.define("shift-contact-dialog", ShiftContactDialog);

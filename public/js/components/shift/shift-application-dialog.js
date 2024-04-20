import { html, css, until } from "../../lit-all.min.js";
import { ViewDialog } from "../view-dialog.js";
import { translate } from "../../translate.js";

export class ShiftApplicationDialog extends ViewDialog {
  static properties = {
    _responseStatusCode: { type: Number, state: true },
    routeId: { type: Number },
    shiftNumber: { type: Number },
    publisherId: { type: Number },
    publisherSelection: { type: Boolean },
  };

  static styles = [
    ViewDialog.styles,
    css`
      select {
        font-size: 1em;
        width: 100%;
        touch-action: manipulation;
        cursor: pointer;
        margin-bottom: 4px;
        padding: 6px 12px;
      }
    `,
  ];

  constructor() {
    super();
    this._responseStatusCode = 0;
    this.routeId = 0;
    this.shiftNumber = 0;
    this.publisherId = 0;
    this.publisherSelection = false;
  }

  async _clickApply() {
    const apiUrl = `/api/calendars/1/routes/${this.routeId}/shifts/${this.shiftNumber}/slots`;

    const response = await fetch(apiUrl, {
      method: "POST",
      body: JSON.stringify({
        publisherId: this.publisherId,
      }),
    });

    if (response.status >= 400) {
      console.error({
        statusCode: response.status,
        statusText: response.statusText,
      });
      this._responseStatusCode = response.status;
      return;
    }

    this.dispatchEvent(
      new CustomEvent("update-calendar", {
        bubbles: true,
        cancelable: false,
        composed: true,
      })
    );
    this.open = false;
  }

  /**
   * @returns {string}
   */
  selectTemplate() {
    if (!this.publisherSelection) {
      return "";
    }
    const publishers = fetch(`/api/publishers.json?active=true`).then(
      (response) => response.json()
    );
    return html`<select>
      ${until(
        publishers.then((publishers) =>
          publishers.map((publisher) => {
            if (publisher.id === this.publisherId) {
              return html`<option value="${publisher.id}" selected>
                ${publisher.firstname} ${publisher.lastname}
              </option>`;
            }
            return html`<option value="${publisher.id}">
              ${publisher.firstname} ${publisher.lastname}
            </option>`;
          })
        ),
        html`<span>${translate("Loading")}...</span>`
      )}
    </select>`;
  }

  /**
   * @returns {string}
   */
  errorTemplate() {
    switch (this._responseStatusCode) {
      case 0:
        return "";
      case 409:
        return translate("You have already applied");
      default:
        return translate("Application could not be saved");
    }
  }

  /**
   * @returns {string}
   */
  contentTemplate() {
    return html`
      <link rel="stylesheet" href="css/fontawesome.min.css" />
      <div>
        <p>${this.errorTemplate()}</p>
        ${this.selectTemplate()}
        <view-button type="primary wide" @click="${this._clickApply}">
          <i class="fa-solid fa-check"></i>
          ${translate("Apply")}
        </view-button>
      </div>
    `;
  }
}
customElements.define("shift-application-dialog", ShiftApplicationDialog);

import { html, css, until } from "../../lit-all.min.js";
import { ViewDialog } from "../view-dialog.js";
import { translate } from "../../translate.js";

export class ShiftApplicationDialog extends ViewDialog {
  static properties = {
    defaultPublisherId: { type: Number },
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
    this.defaultPublisherId = 0;
    this.publisherSelection = false;
  }

  _clickApply() {
    console.log("TODO: enter shift");
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
            if (publisher.id === this.defaultPublisherId) {
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
  contentTemplate() {
    return html`
      <link rel="stylesheet" href="css/fontawesome.min.css" />
      <div>
        <p>Error Message</p>
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

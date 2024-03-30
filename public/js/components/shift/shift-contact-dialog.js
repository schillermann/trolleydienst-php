import { html, until } from "../../lit-all.min.js";
import { translate } from "../../translate.js";
import { ViewDialog } from "../view-dialog.js";

export class ShiftContactDialog extends ViewDialog {
  static properties = {
    publisherId: { type: Number },
    editable: { type: Boolean },
  };

  constructor() {
    super();
    this.publisherId = 0;
    this.editable = false;
  }

  _clickDelete() {
    console.log("TODO: delete application");
    this.open = false;
  }

  /**
   * @returns {string}
   */
  buttonTemplate() {
    if (this.editable) {
      return html`<link rel="stylesheet" href="css/fontawesome.min.css" />
        <view-button type="danger wide" @click="${this._clickDelete}">
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
      ? fetch(`/api/publishers/${this.publisherId}.json`).then((response) =>
          response.json()
        )
      : Promise.resolve({});

    return until(
      publisher.then(
        (p) => html`<h3>${p.firstname} ${p.lastname}</h3>
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

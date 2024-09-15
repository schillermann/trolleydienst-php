import { html, css, until } from "../lit-all.min.js";
import { ViewDialog } from "./view-dialog.js";
import { translate } from "../translate.js";

/**
 * @typedef {Object} Publisher
 * @property {number} id
 * @property {string} username
 * @property {string} firstname
 * @property {string} lastname
 * @property {string} email
 * @property {string} phone
 * @property {string} mobile
 * @property {string} congregation
 * @property {string} languages
 * @property {string} publisherNote
 * @property {string} adminNote
 * @property {boolean} active
 * @property {boolean} admin
 * @property {string} loggedOn - 2024-03-12T21:05:44+01:00
 * @property {string} updatedOn - 2024-03-12T21:05:44+01:00
 * @property {string} createdOn - 2023-03-26T11:04:45+02:00
 */

export class PublisherManagementDialog extends ViewDialog {
  static properties = {
    publisherId: { type: Number },
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
    this.publisherId = 0;
  }

  /**
   * @param {SubmitEvent} event
   * @returns {void}
   */
  async _editPublisher(event) {
    event.preventDefault();
    /** @type {HTMLFormControlsCollection} */
    const elements = event.currentTarget.elements;

    const response = await fetch(`/api/publishers/${this.publisherId}`, {
      method: "PUT",
      body: JSON.stringify({
        active: elements["active"].checked,
        admin: elements["admin"].checked,
        firstname: elements["firstname"].value,
        lastname: elements["lastname"].value,
        username: elements["username"].value,
        email: elements["email"].value,
        mobile: elements["mobile"].value,
        phone: elements["phone"].value,
        congregation: elements["congregation"].value,
        languages: elements["languages"].value,
        publisherNote: elements["publisher-note"].value,
        adminNote: elements["admin-note"].value,
      }),
    });

    if (response.ok) {
      this.dispatchEvent(
        new Event("update-publishers", {
          bubbles: true,
          composed: true,
        })
      );
      this.open = false;
      this.publisherId = 0;
      return;
    }

    console.error({
      statusCode: response.status,
      statusText: response.statusText,
    });
    this._errorMessage = translate("Publisher could not be saved.");
  }

  /**
   * @param {SubmitEvent} event
   * @returns {void}
   */
  async _createPublisher(event) {
    event.preventDefault();
    /** @type {HTMLFormControlsCollection} */
    const elements = event.currentTarget.elements;

    const response = await fetch(`/api/publishers`, {
      method: "POST",
      body: JSON.stringify({
        active: elements["active"].checked,
        admin: elements["admin"].checked,
        firstname: elements["firstname"].value,
        lastname: elements["lastname"].value,
        username: elements["username"].value,
        email: elements["email"].value,
        mobile: elements["mobile"].value,
        phone: elements["phone"].value,
        congregation: elements["congregation"].value,
        languages: elements["languages"].value,
        publisherNote: elements["publisher-note"].value,
        adminNote: elements["admin-note"].value,
      }),
    });
    if (!response.ok) {
      console.error({
        statusCode: response.status,
        statusText: response.statusText,
      });
      this._errorMessage = translate("Publisher could not be created.");
      return;
    }

    this.dispatchEvent(
      new Event("update-publishers", {
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
    const response = await fetch(`/api/publishers/${this.publisherId}`, {
      method: "DELETE",
    });

    if (response.ok) {
      this.dispatchEvent(
        new Event("update-calendar-settings", {
          bubbles: true,
          composed: true,
        })
      );
      this.publisherId = 0;
      this.open = false;
      return;
    }

    console.error({
      statusCode: response.status,
      statusText: response.statusText,
    });
    this._errorMessage = translate("Publisher could not be deleted.");
  }

  /**
   * @returns {string}
   */
  _buttonDeleteTemplate() {
    if (this.publisherId === 0) {
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
    /** @type {Publisher} */
    const publisherResponse = this.publisherId
      ? fetch(`/api/publishers/${this.publisherId}`).then((response) =>
          response.json()
        )
      : Promise.resolve().then(() => {
          return {
            active: true,
            admin: false,
            username: "",
            firstname: "",
            lastname: "",
          };
        });

    return html`
      <link rel="stylesheet" href="css/fontawesome.min.css" />
      <p>${this._errorMessage}</p>
      <form
        @submit=${(event) =>
          this.publisherId
            ? this._editPublisher(event)
            : this._createPublisher(event)}
      >
        ${until(
          publisherResponse.then(
            (publisher) => html`<dl>
              <dt>
                <label for="active">${translate("Active")}:</label>
              </dt>
              <dd>
                <input
                  id="active"
                  type="checkbox"
                  name="active"
                  ?checked=${publisher.active === true}
                />
              </dd>

              <dt>
                <label for="admin">${translate("Admin Rights")}:</label>
              </dt>
              <dd>
                <input
                  id="admin"
                  type="checkbox"
                  name="admin"
                  ?checked=${publisher.admin === true}
                />
              </dd>

              <dt>
                <label for="firstname">${translate("Firstname")}:</label>
              </dt>
              <dd>
                <input
                  type="text"
                  id="firstname"
                  name="firstname"
                  value="${publisher.firstname}"
                  required
                />
              </dd>

              <dt>
                <label for="lastname">${translate("Lastname")}:</label>
              </dt>
              <dd>
                <input
                  type="text"
                  id="lastname"
                  name="lastname"
                  value="${publisher.lastname}"
                  required
                />
              </dd>

              <dt>
                <label for="username">${translate("Username")}:</label>
              </dt>
              <dd>
                <input
                  type="text"
                  id="username"
                  name="username"
                  value="${publisher.username}"
                  required
                />
              </dd>

              <dt>
                <label for="email">${translate("Email")}:</label>
              </dt>
              <dd>
                <input
                  type="email"
                  id="email"
                  name="email"
                  value="${publisher.email}"
                  required
                />
              </dd>

              <dt>
                <label for="mobile">${translate("Mobile")}:</label>
              </dt>
              <dd>
                <input
                  type="tel"
                  id="mobile"
                  name="mobile"
                  value="${publisher.mobile}"
                />
              </dd>

              <dt>
                <label for="phone">${translate("Phone")}:</label>
              </dt>
              <dd>
                <input
                  type="tel"
                  id="phone"
                  name="phone"
                  value="${publisher.phone}"
                />
              </dd>

              <dt>
                <label for="congregation">${translate("Congregation")}:</label>
              </dt>
              <dd>
                <input
                  type="text"
                  id="congregation"
                  name="congregation"
                  value="${publisher.congregation}"
                />
              </dd>

              <dt>
                <label for="languages">${translate("Languages")}:</label>
              </dt>
              <dd>
                <input
                  type="text"
                  id="languages"
                  name="languages"
                  value="${publisher.languages}"
                />
              </dd>

              <dt>
                <label for="publisher-note"
                  >${translate("Publisher Note")}:</label
                >
              </dt>
              <dd>
                <textarea id="publisher-note" name="publisher-note">
${publisher.publisherNote}</textarea
                >
              </dd>

              <dt>
                <label for="admin-note">${translate("Admin Note")}:</label>
              </dt>
              <dd>
                <textarea id="admin-note" name="admin-note">
${publisher.adminNote}</textarea
                >
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
customElements.define("publisher-management-dialog", PublisherManagementDialog);

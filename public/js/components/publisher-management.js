import { LitElement, css, html, until } from "../lit-all.min.js";
import { translate } from "../translate.js";
import "./publisher-management-dialog.js";
import "./view-search.js";
import "./view-button.js";

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
 * @property {string} language
 * @property {string} publisherNote
 * @property {string} adminNote
 * @property {boolean} active
 * @property {boolean} admin
 * @property {string} loggedOn - 2024-03-12T21:05:44+01:00
 * @property {string} updatedOn - 2024-03-12T21:05:44+01:00
 * @property {string} createdOn - 2023-03-26T11:04:45+02:00
 */

export class PublisherManagement extends LitElement {
  /** @type {string} */
  _searchNameOrEmail;

  static styles = css`
    section {
      overflow-x: auto;
    }

    nav {
      margin: 20px 0px 20px 0px;

      view-search {
        float: right;
      }
    }

    table {
      width: 100%;

      th {
        color: var(--td-brand-white-90);
        background-color: var(--td-brand-purple-62);
        text-align: left;
        padding: 10px;
        font-size: 17px;
      }

      tr:nth-child(even) {
        background-color: var(--td-background-content-accent-color);
      }

      td {
        padding: 6px;
      }
    }

    .fa-check {
      color: var(--td-secondary-green);
    }

    .fa-times {
      color: var(--td-secondary-red);
    }
  `;

  constructor() {
    super();
    this._searchNameOrEmail = "";
  }

  /**
   * @param {Event} event
   * @returns {void}
   */
  _handlerSearchPublisher(event) {
    this._searchNameOrEmail = event.detail.search;
    this.requestUpdate();
  }

  /**
   * @returns {void}
   */
  connectedCallback() {
    super.connectedCallback();
    this.addEventListener("update-publishers", () => {
      this.requestUpdate();
    });
    this.addEventListener("search", this._handlerSearchPublisher);
  }

  /**
   * @param {Event} event
   * @returns {void}
   */
  _openDialog(event) {
    /** @type {Element} */
    const dialog = this.renderRoot.querySelector("publisher-management-dialog");
    dialog.setAttribute("open", "true");
    const publisherId = event.currentTarget.getAttribute("publisher-id");
    if (!publisherId) {
      return;
    }
    dialog.setAttribute("publisherId", publisherId);
  }

  render() {
    return html`
      <link rel="stylesheet" href="css/fontawesome.min.css" />
      <publisher-management-dialog
        title="${translate("New Publisher")}"
      ></publisher-management-dialog>
      <nav>
        <view-button type="primary flex" @click="${this._openDialog}">
          <i class="fa-solid fa-plus"></i>
          ${translate("New Publisher")}
        </view-button>
        <view-search></view-search>
      </nav>
      <section>
        <table>
          <tbody>
            <tr>
              <th>${translate("Firstname")}</th>
              <th>${translate("Lastname")}</th>
              <th>${translate("Email")}</th>
              <th>${translate("Active")}</th>
              <th>${translate("Admin")}</th>
              <th>${translate("Last Login")}</th>
              <th>${translate("Action")}</th>
            </tr>
            ${until(
              fetch("/api/publishers?search=" + this._searchNameOrEmail)
                .then((response) => response.json())
                .then(
                  /**
                   * @param {Publisher[]} publishers
                   */
                  (publishers) =>
                    publishers.map(
                      (publisher) => html`<tr>
                        <td>${publisher.firstname}</td>
                        <td>${publisher.lastname}</td>
                        <td>${publisher.email}</td>
                        <td>
                          ${publisher.active
                            ? html`<i class="fa fa-check"></i>`
                            : html`<i class="fa fa-times"></i>`}
                        </td>
                        <td>
                          ${publisher.admin
                            ? html`<i class="fa fa-check"></i>`
                            : html`<i class="fa fa-times"></i>`}
                        </td>
                        <td>
                          ${new Date(publisher.loggedOn).toLocaleString()}
                        </td>
                        <td>
                          <view-button
                            type="flex"
                            publisher-id="${publisher.id}"
                            @click="${this._openDialog}"
                            ><i class="fa-solid fa-pencil"></i> ${translate(
                              "Edit"
                            )}</view-button
                          >
                        </td>
                      </tr>`
                    )
                ),
              html`<span>${translate("Loading")}...</span>`
            )}
          </tbody>
        </table>
        <section></section>
      </section>
    `;
  }
}
customElements.define("publisher-management", PublisherManagement);

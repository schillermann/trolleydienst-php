"use strict";

import "./../button/index.js";
import { FrontierElement } from "../frontier-element.js";

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
 * @property {string} active
 * @property {string} administrative
 * @property {string} loggedOn
 * @property {string} updatedOn
 * @property {string} createdOn
 */

export class ShiftDialogPublisher extends FrontierElement {
  static observedAttributes = ["lang", "open", "publisher-id", "editable"];

  constructor() {
    super();
  }

  /**
   * @param {Event} event
   * @returns {void}
   */
  closeDialog(event) {
    this.setAttribute("open", "false");
  }

  disconnectedCallback() {
    const buttonDelete = this.shadowRoot.getElementById("button-delete");
    if (buttonDelete) {
      buttonDelete.removeEventListener(
        "click",
        this.sendDeleteShiftApplication
      );
    }

    this.shadowRoot
      .querySelector("button-cancel")
      .removeEventListener("click", this.closeDialog);
  }

  /**
   * @returns {Promise<void>}
   */
  async update() {
    await super.update();
    const dialog = this.shadowRoot.querySelector("dialog");
    if (this.getAttribute("open") === "true") {
      dialog.showModal();
    } else {
      dialog.close();
    }
  }

  /**
   * @param {string} template
   * @returns {void}
   */
  render(template) {
    super.render(template);

    const buttonDelete = this.shadowRoot.getElementById("button-delete");
    if (buttonDelete) {
      buttonDelete.addEventListener(
        "click",
        this.sendDeleteShiftApplication.bind(this)
      );
    }

    this.shadowRoot
      .getElementById("button-cancel")
      .addEventListener("click", this.closeDialog.bind(this));
  }

  /**
   * @param {Event} event
   * @returns {Promise<void>}
   */
  async sendDeleteShiftApplication(event) {
    const apiUrl =
      "/api/calendars/1/shifts/" +
      this.getAttribute("shift-id") +
      "/positions/" +
      this.getAttribute("shift-position") +
      "/publishers/" +
      this.getAttribute("publisher-id") +
      "/applications";

    const response = await fetch(apiUrl, {
      method: "DELETE",
    });

    if (response.status === 204) {
      this.setAttribute("open", "false");
    }
  }

  /**
   * @returns {string}
   */
  header() {
    switch (this.getAttribute("lang")) {
      case "de":
        return "Verkündiger Kontakt";
      default:
        return "Publisher Contact";
    }
  }

  /**
   * @returns {string}
   */
  labelEmail() {
    switch (this.getAttribute("lang")) {
      case "de":
        return "E-Mail";
      default:
        return "Email";
    }
  }

  /**
   * @returns {string}
   */
  labelPhone() {
    switch (this.getAttribute("lang")) {
      case "de":
        return "Festnetz";
      default:
        return "Phone";
    }
  }

  /**
   * @returns {string}
   */
  labelMobile() {
    switch (this.getAttribute("lang")) {
      case "de":
        return "Mobil";
      default:
        return "Mobile";
    }
  }

  /**
   * @returns {string}
   */
  labelInfo() {
    switch (this.getAttribute("lang")) {
      case "de":
        return "Info vom Verkündiger";
      default:
        return "Info From Publisher";
    }
  }

  /**
   * @returns {string}
   */
  buttonLabelClose() {
    switch (this.getAttribute("lang")) {
      case "de":
        return "Schließen";
      default:
        return "Close";
    }
  }

  /**
   * @returns {string}
   */
  buttonLabelDelete() {
    switch (this.getAttribute("lang")) {
      case "de":
        return "Löschen";
      default:
        return "Delete";
    }
  }

  /**
   * @returns {string}
   */
  templateDeleteButton() {
    if (this.getAttribute("editable") === "true") {
      return /*html*/ `<dialog-button-danger id="button-delete">
          ${this.buttonLabelDelete()}
        </dialog-button-danger>`;
    }
    return "";
  }

  /**
   * @returns {Promise<string>}
   */
  async template() {
    const publisherId = Number(this.getAttribute("publisher-id"));
    const publisher =
      publisherId === 0 ? {} : await this.publisherJson(publisherId);

    if (this.debug()) {
      console.log(`call async template()`);
      console.log("// publisherId: ", publisherId);
      console.log("// publisher: ", publisher);
    }

    return /*html*/ `
      <style></style>

      <dialog>
        <header>
          <h2>${this.header()}</h2>
        </header>
        <div>
          <h3>${publisher.firstname} ${publisher.lastname}</h3>
          <address>
            <dl>
              <dt>${this.labelEmail()}:</dt>
              <dd><a href="mailto:${publisher.email}">${
      publisher.email
    }</a></dd>
              <dt>${this.labelPhone()}:</dt>
              <dd><a href="tel:${publisher.phone}">${publisher.phone}</a></dd>
              <dt>${this.labelMobile()}:</dt>
              <dd><a href="tel:${publisher.mobile}">${publisher.mobile}</a></dd>
            </dl>
          </address>
          <h4>${this.labelInfo()}</h4>
          <p>${publisher.publisherNote}</p>
        </div>
        <div>
          ${this.templateDeleteButton()}
          <dialog-button id="button-cancel">${this.buttonLabelClose()}</dialog-button>
        </div>
      </dialog>
    `;
  }

  /**
   * @param {number} publisherId
   * @returns {Promise<Publisher>}
   */
  async publisherJson(publisherId) {
    const apiUrl = "/api/publishers/" + publisherId;
    const response = await fetch(apiUrl, {
      method: "GET",
      headers: { "Content-Type": "application/json" },
    });

    if (response.status !== 200) {
      throw new Error("Cannot read publisher from api [url: " + apiUrl + "]");
    }
    return await response.json();
  }
}

window.customElements.define("shift-dialog-publisher", ShiftDialogPublisher);

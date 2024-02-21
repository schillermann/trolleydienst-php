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

export class ShiftDialogPublisherContact extends FrontierElement {
  static observedAttributes = ["open", "lang", "publisher-id"];

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

  async connectedCallback() {
    await this.renderTemplate();
    this.shadowRoot
      .getElementById("button-close")
      .addEventListener("click", this.closeDialog.bind(this));
  }

  disconnectedCallback() {
    this.shadowRoot.removeEventListener("click", this.closeDialog);
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
  buttonLabel() {
    switch (this.getAttribute("lang")) {
      case "de":
        return "Schließen";
      default:
        return "Close";
    }
  }

  /**
   * @returns {Promise<string>}
   */
  async template() {
    const publisherId = Number(this.getAttribute("publisher-id"));
    const publisher =
      publisherId === 0 ? {} : await this.publisherJson(publisherId);
    const open = this.getAttribute("open") === "true" ? "open" : "";

    return /*html*/ `
      <style></style>
    
      <dialog ${open}>
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
          <dialog-button id="button-close">${this.buttonLabel()}</dialog-button>
        </div>
      </dialog>
    `;
  }

  /**
   *
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

window.customElements.define(
  "shift-dialog-publisher-contact",
  ShiftDialogPublisherContact
);

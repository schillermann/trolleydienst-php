"use strict";

import { ShiftCardTime } from "./shift-card-time.js";
import { ShiftCardButtonPublisherAction } from "./shift-card-button-publisher-action.js";
import { ShiftCardButtonPublisherContact } from "./shift-card-button-publisher-contact.js";
import { ShiftCardButtonAvailable } from "./shift-card-button-available.js";
import { FrontierElement } from "../frontier-element.js";

export class ShiftCardPosition extends FrontierElement {
  static observedAttributes = [
    "publisher-list",
    "publisher-limit",
    "shift-id",
    "calendar-id",
    "shift-position",
    "shift-from",
    "shift-to",
    "lang",
  ];

  constructor() {
    super();
  }

  async connectedCallback() {
    this.render();
    customElements.get("shift-card-time") ||
      window.customElements.define("shift-card-time", ShiftCardTime);
    customElements.get("shift-card-button-publisher-contact") ||
      window.customElements.define(
        "shift-card-button-publisher-contact",
        ShiftCardButtonPublisherContact
      );
    customElements.get("shift-card-button-available") ||
      window.customElements.define(
        "shift-card-button-available",
        ShiftCardButtonAvailable
      );
  }

  /**
   * @returns {string}
   */
  template() {
    const publishers = JSON.parse(this.getAttribute("publisher-list"));
    // TODO: Add right time
    return /*html*/ `
      <dl>          
        <dt>
          <shift-card-time lang="${this.getAttribute(
            "lang"
          )}" date-from="${new Date().toString()}" date-to="${new Date().toString()}"></shift-card-time>
        </dt>
        <dd>
          ${this.publisherContactButtons(publishers)}
          ${this.availableButtons(
            publishers,
            this.getAttribute("publisher-limit")
          )}
        </dd>
      </dl>
    `;
  }

  /**
   * @returns {string}
   */
  publisherContactButtons(publishers) {
    return publishers
      .map(
        (publisher) => /*html*/ `<shift-card-button-publisher-contact
          lang="${this.getAttribute("lang")}"
          shift-id="${this.getAttribute("shift-id")}"
          calendar-id="${this.getAttribute("calendar-id")}"
          shift-position="${this.getAttribute("shift-position")}"
          publisher-id="${publisher.id}">
          ${publisher.name}
        </shift-card-button-publisher-contact>`
      )
      .join("");
  }

  /**
   * @returns {string}
   */
  availableButtons(publishers, publisherLimit) {
    const limit = publisherLimit - publishers.length;
    let buttons = "";
    for (let counter = 0; counter < limit; counter++) {
      buttons += /*html*/ `<shift-card-button-available
          lang="${this.getAttribute("lang")}"
          shift-id="${this.getAttribute("shift-id")}"
          calendar-id="${this.getAttribute("calendar-id")}"
          shift-position="${this.getAttribute("shift-position")}">
        </shift-card-button-available>`;
    }

    return buttons;
  }
}

"use strict";

import { ShiftCardTime } from "./shift-card-time.js";
import { ShiftCardButtonPublisherAction } from "./shift-card-button-publisher-action.js";
import { ShiftCardButtonPublisherContact } from "./shift-card-button-publisher-contact.js";
import { ShiftCardButtonAvailable } from "./shift-card-button-available.js";
import { FrontierElement } from "../frontier-element.js";

export class ShiftCardPosition extends FrontierElement {
  constructor() {
    super();
  }

  connectedCallback() {
    const shiftCardTime = this.shadowRoot.querySelector("shift-card-time");
    // TODO: Add right time
    shiftCardTime.setAttribute("date-from", new Date().toString());
    shiftCardTime.setAttribute("date-to", new Date().toString());

    customElements.get("shift-card-time") ||
      window.customElements.define("shift-card-time", ShiftCardTime);
    customElements.get("shift-card-button-publisher-action") ||
      window.customElements.define(
        "shift-card-button-publisher-action",
        ShiftCardButtonPublisherAction
      );

    const dd = this.shadowRoot.querySelector("dd");
    const numberOfButtonsCreated = this.createButtonsPublisherContact(dd);
    this.createButtonsAvailable(
      dd,
      this.getAttribute("publisher-limit") - numberOfButtonsCreated
    );
  }

  /**
   * @returns {string}
   */
  render() {
    return /*html*/ `
      <dl>          
        <dt>
          <shift-card-time language-code="en"></shift-card-time>
        </dt>
        <dd>
          <shift-card-button-publisher-action language-code="en"></shift-card-button-publisher-action>
        </dd>
      </dl>
    `;
  }

  /**
   * @param {HTMLElement} element
   * @returns {number} - Number of created buttons
   */
  createButtonsPublisherContact(element) {
    let numberOfButtons = 0;
    const publishers = JSON.parse(this.getAttribute("publishers"));

    for (const publisherId in publishers) {
      const shiftCardButtonPublisherContact = document.createElement(
        "shift-card-button-publisher-contact"
      );
      shiftCardButtonPublisherContact.setAttribute(
        "shift-id",
        this.getAttribute("shift-id")
      );
      shiftCardButtonPublisherContact.setAttribute(
        "calendar-id",
        this.getAttribute("calendar-id")
      );
      shiftCardButtonPublisherContact.setAttribute(
        "shift-position",
        this.getAttribute("shift-position")
      );
      shiftCardButtonPublisherContact.setAttribute("publisher-id", publisherId);
      shiftCardButtonPublisherContact.setAttribute("language-code", "en");

      shiftCardButtonPublisherContact.innerText = publishers[publisherId];

      element.appendChild(shiftCardButtonPublisherContact);
      customElements.get("shift-card-button-publisher-contact") ||
        window.customElements.define(
          "shift-card-button-publisher-contact",
          ShiftCardButtonPublisherContact
        );
      numberOfButtons++;
    }
    return numberOfButtons;
  }

  /**
   * @param {HTMLElement} element
   * @param {void}
   */
  createButtonsAvailable(element, numberOfButtons) {
    for (
      let createdButtons = 0;
      createdButtons < numberOfButtons;
      createdButtons++
    ) {
      const shiftCardButtonAvailable = document.createElement(
        "shift-card-button-available"
      );
      shiftCardButtonAvailable.setAttribute(
        "shift-id",
        this.getAttribute("shift-id")
      );
      shiftCardButtonAvailable.setAttribute(
        "calendar-id",
        this.getAttribute("calendar-id")
      );
      shiftCardButtonAvailable.setAttribute(
        "shift-position",
        this.getAttribute("shift-position")
      );
      shiftCardButtonAvailable.setAttribute("language-code", "en");
      element.appendChild(shiftCardButtonAvailable);
      customElements.get("shift-card-button-available") ||
        window.customElements.define(
          "shift-card-button-available",
          ShiftCardButtonAvailable
        );
    }
  }
}

"use strict";

import { ShiftCardTime } from "./shift-card-time.js";
import { ShiftCardButtonAddPublisher } from "./shift-card-button-add-publisher.js";
import { ShiftCardButtonAvailable } from "./shift-card-button-available.js";
import { ShiftCardButtonPublisher } from "./shift-card-button-publisher.js";
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
    customElements.get("shift-card-button-add-publisher") ||
      window.customElements.define(
        "shift-card-button-add-publisher",
        ShiftCardButtonAddPublisher
      );

    this.createPublisherButtons();
  }

  /**
   *
   * @returns {string}
   */
  render() {
    return /*html*/ `
      <dl>          
        <dt>
          <shift-card-time language-code="en"></shift-card-time>
        </dt>
        <dd>
          <shift-card-button-add-publisher language-code="en"></shift-card-button-add-publisher>
        </dd>
      </dl>
    `;
  }

  async createPublisherButtons() {
    // TODO: Add buttons to tag who is empty
    const dd = this.shadowRoot.querySelector("dd");
    let numberOfPublisherNameButtons = 0;
    const publishers = JSON.parse(this.getAttribute("publishers"));
    for (const publisherId in publishers) {
      const shiftCardButtonPublisher = document.createElement(
        "shift-card-button-publisher"
      );
      shiftCardButtonPublisher.setAttribute(
        "shift-id",
        this.getAttribute("shift-id")
      );
      shiftCardButtonPublisher.setAttribute(
        "shift-type-id",
        this.getAttribute("shift-type-id")
      );
      shiftCardButtonPublisher.setAttribute(
        "shift-position",
        this.getAttribute("shift-position")
      );
      shiftCardButtonPublisher.setAttribute("publisher-id", publisherId);
      shiftCardButtonPublisher.setAttribute("language-code", "en");

      shiftCardButtonPublisher.innerText = publishers[publisherId];

      dd.appendChild(shiftCardButtonPublisher);
      customElements.get("shift-card-button-publisher") ||
        window.customElements.define(
          "shift-card-button-publisher",
          ShiftCardButtonPublisher
        );
      numberOfPublisherNameButtons++;
    }

    for (
      let numberOfAvailableButtons = numberOfPublisherNameButtons;
      numberOfAvailableButtons < this.getAttribute("publisher-limit");
      numberOfAvailableButtons++
    ) {
      const shiftCardButtonAvailable = document.createElement(
        "shift-card-button-available"
      );
      shiftCardButtonAvailable.setAttribute(
        "shift-id",
        this.getAttribute("shift-id")
      );
      shiftCardButtonAvailable.setAttribute(
        "shift-type-id",
        this.getAttribute("shift-type-id")
      );
      shiftCardButtonAvailable.setAttribute(
        "shift-position",
        this.getAttribute("shift-position")
      );
      shiftCardButtonAvailable.setAttribute("language-code", "en");
      dd.appendChild(shiftCardButtonAvailable);
      customElements.get("shift-card-button-available") ||
        window.customElements.define(
          "shift-card-button-available",
          ShiftCardButtonAvailable
        );
    }
  }
}

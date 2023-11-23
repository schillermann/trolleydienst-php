"use strict";

import { ShiftCardPosition } from "./shift-card-position.js";
import { ShiftCardTitle } from "./shift-card-title.js";
import { ShiftCardButtonEdit } from "./shift-card-button-edit.js";

const template = document.createElement("template");
template.innerHTML = /*html*/ `
  <style>
    #shift-card {
      background-color: var(--grey-25);
    }
  </style>

  <div id="shift-card">
    <div>
      <shift-card-title></shift-card-title>
    </div>
    <div id="shift-position"></div>
    <div>
      <shift-card-button-edit language-code="en"></shift-card-button-edit>
    </div>
  </div>
`;

export class ShiftCard extends HTMLElement {
  constructor() {
    super();

    /** @type {ShadowRoot} */
    this._shadowRoot = this.attachShadow({ mode: "open" });
    this._shadowRoot.appendChild(template.content.cloneNode(true));
  }

  async connectedCallback() {
    /** @type {Element} */
    const shiftCardTitle = this._shadowRoot.querySelector("shift-card-title");
    shiftCardTitle.setAttribute("date", this.getAttribute("date"));
    shiftCardTitle.setAttribute("route-name", this.getAttribute("route-name"));

    customElements.get("shift-card-title") ||
      window.customElements.define("shift-card-title", ShiftCardTitle);
    customElements.get("shift-card-position") ||
      window.customElements.define("shift-card-position", ShiftCardPosition);
    customElements.get("shift-card-button-edit") ||
      window.customElements.define(
        "shift-card-button-edit",
        ShiftCardButtonEdit,
      );

    const apiUrl =
      "/api/shift/shift-created?shift-type-id=" +
      this.getAttribute("shift-type-id") +
      "&shift-id=" +
      this.getAttribute("shift-id");
    const response = await fetch(apiUrl, {
      method: "GET",
      headers: { "Content-Type": "application/json" },
    });

    if (response.status !== 200) {
      console.error("Cannot read shift from api");
      return;
    }

    const shift = await response.json();
    const shiftPositionSection =
      this._shadowRoot.getElementById("shift-position");

    for (const shiftPosition of shift.positions) {
      const shiftPositionElement = document.createElement(
        "shift-card-position",
      );
      shiftPositionElement.setAttribute(
        "shift-id",
        this.getAttribute("shift-id"),
      );
      shiftPositionElement.setAttribute(
        "shift-type-id",
        this.getAttribute("shift-type-id"),
      );
      shiftPositionElement.setAttribute(
        "shift-position",
        shiftPosition.position,
      );
      shiftPositionElement.setAttribute("from", shiftPosition.from);
      shiftPositionElement.setAttribute("to", shiftPosition.to);
      shiftPositionElement.setAttribute(
        "language-code",
        this.getAttribute("language-code"),
      );
      shiftPositionElement.setAttribute(
        "publisher-limit",
        this.getAttribute("publisher-limit"),
      );

      let publishers = [];
      for (const publisher of shiftPosition.publishers) {
        publishers.push(
          publisher.id +
            "[" +
            publisher.firstname +
            " " +
            publisher.lastname +
            "]",
        );
      }

      shiftPositionElement.setAttribute("publishers", publishers.join(" "));
      shiftPositionSection.appendChild(shiftPositionElement);

      customElements.get("shift-card-position") ||
        window.customElements.define("shift-card-position", ShiftCardPosition);
    }
  }
}

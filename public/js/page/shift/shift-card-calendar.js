"use strict";

import { ShiftCard } from "./shift-card.js";

export class ShiftCardCalendar extends HTMLElement {
  constructor() {
    super();

    /** @type {ShadowRoot} */
    this._shadowRoot = this.attachShadow({ mode: "open" });
  }

  async connectedCallback() {
    const apiUrl =
      "/api/shift/shifts-created?shift-type-id=" +
      this.getAttribute("shift-type-id");
    const response = await fetch(apiUrl, {
      method: "GET",
      headers: { "Content-Type": "application/json" },
    });

    if (response.status !== 200) {
      console.error("Cannot read shifts from api");
      return;
    }

    for (const shift of await response.json()) {
      const shiftCard = document.createElement("shift-card");
      shiftCard.setAttribute("date", shift.date);
      shiftCard.setAttribute("shift-id", shift.id);
      shiftCard.setAttribute("shift-type-id", shift.typeId);
      shiftCard.setAttribute("color", shift.color);
      shiftCard.setAttribute("publisher-limit", shift.publisherLimit);
      shiftCard.setAttribute("route-name", shift.routeName);
      shiftCard.setAttribute(
        "language-code",
        this.getAttribute("language-code"),
      );

      this._shadowRoot.appendChild(shiftCard);
    }

    customElements.get("shift-card") ||
      window.customElements.define("shift-card", ShiftCard);
  }
}

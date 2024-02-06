"use strict";

import { ShiftCard } from "./shift-card.js";

export class ShiftCardCalendar extends HTMLElement {
  constructor() {
    super();

    /** @type {ShadowRoot} */
    this._shadowRoot = this.attachShadow({ mode: "open" });
  }

  async connectedCallback() {
    const shiftApiUrl =
      "/api/shifts?shift-type-id=" + this.getAttribute("shift-type-id");
    const shiftResponse = await fetch(shiftApiUrl, {
      method: "GET",
      headers: { "Content-Type": "application/json" },
    });

    if (shiftResponse.status !== 200) {
      console.error("Cannot read shifts from api [url: " + shiftApiUrl + "]");
      return;
    }

    const shiftTypeApiUrl =
      "/api/shift-types/" + this.getAttribute("shift-type-id");
    const shiftTypeResponse = await fetch(shiftTypeApiUrl, {
      method: "GET",
      headers: { "Content-Type": "application/json" },
    });

    if (shiftTypeResponse.status !== 200) {
      console.error(
        "Cannot read shift type from api [url: " + shiftTypeApiUrl + "]",
      );
      return;
    }
    const shiftType = await shiftTypeResponse.json();
    for (const shift of await shiftResponse.json()) {
      const shiftCard = document.createElement("shift-card");
      shiftCard.setAttribute("date", shift.start);
      shiftCard.setAttribute("shift-id", shift.id);
      shiftCard.setAttribute("shift-type-id", shift.typeId);
      shiftCard.setAttribute("color", shift.colorHex);
      shiftCard.setAttribute(
        "publisher-limit",
        shiftType.publisherLimitPerShift,
      );
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

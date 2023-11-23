"use strict";

const template = document.createElement("template");
template.innerHTML = /*html*/ `
  <p>
    <span id="date-from">Date From</span> - <span id="date-to">Date To</span>
  </p>
`;

export class ShiftCardTime extends HTMLElement {
  constructor() {
    super();

    /** @type {ShadowRoot} */
    this._shadowRoot = this.attachShadow({ mode: "open" });
    this._shadowRoot.appendChild(template.content.cloneNode(true));
  }

  /**
   * @returns {Array}
   */
  static get observedAttributes() {
    return ["date-from", "date-to"];
  }

  /**
   * @param {string} name attribute name
   * @param {string} oldVal
   * @param {string} newVal
   * @returns
   */
  attributeChangedCallback(name, oldVal, newVal) {
    if (name === "date-from") {
      const dateFrom = new Date(newVal);
      if (dateFrom.toString() === "Invalid Date") {
        return;
      }
      const hours = dateFrom.getHours();
      const minutes = new String("0" + dateFrom.getMinutes()).slice(-2);
      this._shadowRoot.querySelector(
        "#date-from",
      ).innerText = `${hours}:${minutes}`;
      return;
    }

    if (name === "date-to") {
      const dateTo = new Date(newVal);
      if (dateTo.toString() === "Invalid Date") {
        return;
      }
      const hours = dateTo.getHours();
      const minutes = new String("0" + dateTo.getMinutes()).slice(-2);

      this._shadowRoot.querySelector(
        "#date-to",
      ).innerText = `${hours}:${minutes}`;
    }
  }
}

"use strict";

import { FrontierElement } from "../frontier-element.js";

export class ShiftDialogSelectmenuPublishers extends FrontierElement {
  static observedAttributes = ["selected-publisher-id"];

  constructor() {
    super();
  }

  /**
   * @param {Event} event
   * @returns {void}
   */
  onChangeMenu(event) {
    this.dispatchEvent(
      new CustomEvent("selectmenu-change", {
        bubbles: true,
        composed: true,
        detail: {
          publisherId: Number(event.target.value),
        },
      })
    );
  }

  /**
   * @returns {void}
   */
  connectedCallback() {
    this.shadowRoot
      .querySelector("select")
      .addEventListener("change", this.onChangeMenu);
  }

  /**
   * @returns {void}
   */
  disconnectedCallback() {
    this.shadowRoot
      .querySelector("select")
      .removeEventListener("change", this.onChangeMenu);
  }

  /**
   * @param {string} name
   * @param {string} oldVal
   * @param {string} newVal
   * @returns {void}
   */
  async attributeChangedCallback(name, oldVal, newVal) {
    this.render();
    if (name !== "selected-publisher-id") {
      return;
    }

    const response = await fetch("/api/shift/publishers-enabled");
    const select = this.shadowRoot.querySelector("select");

    for (const publisher of await response.json()) {
      const option = document.createElement("option");
      option.value = publisher.id;
      option.innerHTML = publisher.name;
      if (publisher.id == newVal) {
        option.setAttribute("selected", "selected");
      }
      select.appendChild(option);
    }
    select.dispatchEvent(new Event("change"));
  }

  /**
   * @returns {string}
   */
  template() {
    return /*html*/ `
      <style>
        select {
          width: 100%;
        }
      </style>

      <select></select>
    `;
  }
}

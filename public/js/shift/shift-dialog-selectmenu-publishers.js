"use strict";

const template = document.createElement("template");
template.innerHTML = /*html*/ `
  <style>
    select {
      width: 100%;
    }
  </style>

  <select></select>
`;

export class ShiftDialogSelectmenuPublishers extends HTMLElement {
  static observedAttributes = ["selected-publisher-id"];

  constructor() {
    super();

    /** @type {ShadowRoot} */
    this._shadowRoot = this.attachShadow({ mode: "open" });
    this._shadowRoot.appendChild(template.content.cloneNode(true));
  }

  onChangeMenu(event) {
    this.dispatchEvent(
      new CustomEvent("selectmenu-change", {
        bubbles: true,
        composed: true,
        detail: {
          publisherId: event.target.value,
        },
      })
    );
  }

  /**
   * @returns {void}
   */
  connectedCallback() {
    this._shadowRoot
      .querySelector("select")
      .addEventListener("change", this.onChangeMenu);
  }

  /**
   * @returns {void}
   */
  disconnectedCallback() {
    this._shadowRoot
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
    if (name !== "selected-publisher-id") {
      return;
    }

    const response = await fetch("/api/shift/publishers-enabled");

    for (const publisher of await response.json()) {
      const select = this._shadowRoot.querySelector("select");
      const option = document.createElement("option");
      option.value = publisher.id;
      option.innerHTML = publisher.name;
      if (publisher.id == newVal) {
        option.setAttribute("selected", "selected");
      }
      select.appendChild(option);
    }
  }
}
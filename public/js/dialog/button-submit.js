"use strict";

const template = document.createElement("template");
template.innerHTML = /*html*/ `
  <style>
    input {
      width: 100%;
    }
  </style>
  <input type="submit" value="Label">
`;

export default class DialogButtonSubmit extends HTMLElement {
  static observedAttributes = ["label"];

  constructor() {
    super();

    /** @type {ShadowRoot} */
    this._shadowRoot = this.attachShadow({ mode: "open" });
    this._shadowRoot.appendChild(template.content.cloneNode(true));
  }

  /**
   * @param {string} name attribute name
   * @param {string} oldVal
   * @param {string} newVal
   * @returns
   */
  attributeChangedCallback(name, oldVal, newVal) {
    if (name !== "label") {
      return;
    }
    this._shadowRoot.querySelector("input").value = newVal;
  }
}

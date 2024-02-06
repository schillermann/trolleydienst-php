"use strict";

const template = document.createElement("template");
template.innerHTML = /*html*/ `
  <style>
    button {
      background-color: var(--main-color);
      color: var(--white);
      width: 100%;
    }
  </style>
  <button>
    <slot />
  </button> 
`;

export class DialogButtonPrimary extends HTMLElement {
  constructor() {
    super();

    /** @type {ShadowRoot} */
    this._shadowRoot = this.attachShadow({ mode: "open" });
    this._shadowRoot.appendChild(template.content.cloneNode(true));
  }
}

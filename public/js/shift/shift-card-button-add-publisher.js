"use strict";

const template = document.createElement("template");
template.innerHTML = /*html*/ `
  <style>
    @import url("css/font-awesome.min.css");

    @media (prefers-color-scheme: dark) {
      button {
        color: rgb(191, 191, 191);
        background-color: rgb(31, 31, 31);
      }
    }
    button {
      width: 45px;
      transition: box-shadow .28s;
      padding: 6px 12px;
      line-height: 1.42857143;
      font-size: 1rem;
      cursor: pointer;
      background-image: none;
      border: 1px solid rgba(189, 183, 181, 0.5);
      color: var(--black);
      margin-bottom: 4px;
      border-radius: 5px;
      background-color: var(--check-color);
      float: right;
    }
  </style>
  <button type="button">
    <i class="fa fa-user-plus"></i>
  </button>
`;

export class ShiftCardButtonAddPublisher extends HTMLElement {
  constructor() {
    super();

    /** @type {ShadowRoot} */
    this._shadowRoot = this.attachShadow({ mode: "open" });
    this._shadowRoot.appendChild(template.content.cloneNode(true));
  }

  /**
   * @param {Event} event
   * @returns {void}
   */
  fireClickEvent(event) {
    this.dispatchEvent(
      new Event("add-click", {
        bubbles: true,
        composed: true,
      })
    );
  }

  /**
   * @returns {void}
   */
  connectedCallback() {
    this._shadowRoot
      .querySelector("button")
      .addEventListener("click", this.fireClickEvent, true);
  }
}

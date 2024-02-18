"use strict";

import { FrontierElement } from "../frontier-element.js";

export class ShiftCardButtonPublisherAction extends FrontierElement {
  constructor() {
    super();
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
    this.render();
    this.shadowRoot
      .querySelector("button")
      .addEventListener("click", this.fireClickEvent, true);
  }

  /**
   * @returns {string}
   */
  template() {
    return /*html*/ `
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
  }
}

window.customElements.define(
  "shift-card-button-publisher-action",
  ShiftCardButtonPublisherAction
);

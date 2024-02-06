"use strict";

import { FrontierElement } from "../forntier-element.js";

export class ShiftCardButtonAvailable extends FrontierElement {
  static observedAttributes = ["language-code"];

  constructor() {
    super();
  }

  /**
   * @param {Event} event
   * @returns {void}
   */
  onClick(event) {
    this.dispatchEvent(
      new CustomEvent("open-shift-dialog-application", {
        bubbles: true,
        composed: true,
        detail: {
          shiftId: this.getAttribute("shift-id"),
          shiftTypeId: this.getAttribute("shift-type-id"),
          shiftPosition: this.getAttribute("shift-position"),
        },
      })
    );
  }

  /**
   * @returns {void}
   */
  connectedCallback() {
    this.shadowRoot
      .querySelector("button")
      .addEventListener("click", this.onClick.bind(this));
  }

  /**
   * @param {string} name
   * @param {string} oldVal
   * @param {string} newVal
   * @returns {void}
   */
  attributeChangedCallback(name, oldVal, newVal) {
    if (name !== "language-code") {
      return;
    }

    const label = this.shadowRoot.querySelector("label");
    switch (newVal) {
      case "de":
        label.innerHTML = "Frei";
        break;
    }
  }

  /**
   * @returns {string}
   */
  render() {
    return /*html*/ `
      <style>
        @import url("css/font-awesome.min.css");
    
        button {
          transition: box-shadow .28s;
          padding: 6px 12px;
          line-height: 1.42857143;
          font-size: 1rem;
          vertical-align: middle;
          touch-action: manipulation;
          cursor: pointer;
          user-select: none;
          border: 1px solid rgba(189, 183, 181, 0.5);
          color: var(--black);
          margin-bottom: 4px;
          background-color: var(--grey-25);
          border-radius: 5px;
          width: 180px;
          overflow: hidden;
          text-overflow: ellipsis;
          white-space: nowrap;
        }
        
        button:hover {
          background-color: var(--second-color);
          border-color: var(--second-color);
          background-color: var(--grey-25);
        }
    
        @media (prefers-color-scheme: dark) {
          button {
            color: var(--white);
          }
        }
      </style>
      <button class="button promote apply-shift-button" type="button">
          <i class="fa fa-hand-o-right"></i>
          <label>Available</label>
      </button>
    `;
  }
}
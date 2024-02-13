"use strict";

import { FrontierElement } from "../frontier-element.js";

export class ShiftCardButtonPublisherContact extends FrontierElement {
  constructor() {
    super();
  }

  /**
   * @returns {void}
   */
  disconnectedCallback() {
    this.shadowRoot
      .querySelector("button")
      .removeEventListener("click", this.onClick);
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
   * @param {PointerEvent} event
   * @returns {void}
   */
  onClick(event) {
    this.dispatchEvent(
      new CustomEvent("open-shift-dialog-publisher", {
        bubbles: true,
        composed: true,
        detail: {
          shiftId: parseInt(this.getAttribute("shift-id")),
          calendarId: parseInt(this.getAttribute("calendar-id")),
          shiftPosition: parseInt(this.getAttribute("shift-position")),
          publisherId: parseInt(this.getAttribute("publisher-id")),
        },
      })
    );
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
          border-radius: 5px;
          width: 180px;
          overflow: hidden;
          text-overflow: ellipsis;
          white-space: nowrap;
          background-color: var(--check-color);
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
      <button type="button">
        <i class="fa fa-check-circle-o"></i>
        <slot />
      </button>
    `;
  }
}

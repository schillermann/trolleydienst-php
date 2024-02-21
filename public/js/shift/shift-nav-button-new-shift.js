"use strict";

import { FrontierElement } from "../frontier-element.js";

export class ShiftNavButtonNewShift extends FrontierElement {
  constructor() {
    super();
  }

  /**
   * @returns {string}
   */
  buttonLabel() {
    switch (this.getAttribute("lang")) {
      case "de":
        return "Neue Schicht";
      default:
        return "New Shift";
    }
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
              background-color: var(--main-color);
              color: var(--white);
              transition: box-shadow .28s;
              display: inline-block;
              text-decoration: none;
              padding: 6px 12px;
              line-height: 1.42857143;
              font-size: 1rem;
              text-align: center;
              vertical-align: middle;
              touch-action: manipulation;
              cursor: pointer;
              -webkit-user-select: none;
              -moz-user-select: none;
              -ms-user-select: none;
              user-select: none;
              background-image: none;
              border: 1px solid rgba(189, 183, 181, 0.5);
              margin-bottom: 4px;
              border-radius: 5px;
              overflow: hidden;
              text-overflow: ellipsis;
              white-space: nowrap;
          }

          button:hover {
              background-color: var(--second-color);
              border-color: var(--second-color);
          }

      </style>
      <button type="button">
          <i class="fa fa-plus"></i>
          ${this.buttonLabel()}
      </button>
    `;
  }
}

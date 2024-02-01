"use strict";

import { FrontierElement } from "../forntier-element";

export class DialogButtonPrimary extends FrontierElement {
  constructor() {
    super();
  }

  render(): string {
    return /*html*/ `
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
  }
}

"use strict";

import { Dictionary } from "../dictionary";

const template = document.createElement("template");
template.innerHTML = /*html*/ `
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
    <button type="button">
        <i class="fa fa-pencil"></i> {Edit}
    </button>
`;

export class ShiftCardButtonEdit extends HTMLElement {
  dictionary: Dictionary;
  
  constructor() {
    super();

    this.attachShadow({ mode: "closed" }).appendChild(
      template.content.cloneNode(true)
    );

    this.dictionary = new Dictionary({
      Edit: {
        de: "Bearbeiten",
      },
    });
  }

  /**
   * @param {Event} event
   * @returns {void}
   */
  fireClickEvent(event: Event) {
    this.dispatchEvent(
      new Event("edit-shift-click", {
        bubbles: true,
        composed: true,
      }),
    );
  }

  /**
   * @returns {void}
   */
  connectedCallback() {
    this.shadowRoot
      .querySelector("button")
      .addEventListener("click", this.fireClickEvent, true);
  }

  static get observedAttributes() {
    return ["language-code"];
  }

  attributeChangedCallback(name: string, oldVal: string, newVal: string) {
    if (name !== "language-code") {
      return;
    }

    this.shadowRoot.innerHTML = this.dictionary.innerHTMLEnglishTo(
      newVal,
      this.shadowRoot.innerHTML,
    );
  }
}

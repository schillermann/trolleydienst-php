
"use strict"

const template = document.createElement('template');
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
        <label>Create Shift<label>
    </button>
`;

export class ShiftNavButtonNewShift extends HTMLElement {
    static observedAttributes = ["language-code"];
    
    constructor() {
        super();

        this.attachShadow({ mode: "open" }).appendChild(
          template.content.cloneNode(true)
        );
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

    const label = this.shadowRoot.querySelector("label")
    switch(newVal) {
      case 'de':
        label.innerHTML = 'Neue Schicht'
        break;
    }
  }
}

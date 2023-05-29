"use strict"

const template = document.createElement('template');
template.innerHTML = /*html*/`
    <style>
        button {
            width: 100%;
        }
    </style>
    <button>
        <slot />
    </button>
`;

export default class DialogButton extends HTMLElement {
    constructor() {
        super();

        /** @type {ShadowRoot} */
        this._shadowRoot = this.attachShadow({ mode: 'open' });
        this._shadowRoot.appendChild(template.content.cloneNode(true));
    }
}

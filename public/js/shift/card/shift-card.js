"use strict"

import ShiftCardRow from "./shift-card-row.js"
import ShiftCardTitle from "./shift-card-title.js"
import ShiftCardButtonEdit from "./shift-card-button-edit.js"

const template = document.createElement('template');
template.innerHTML = /*html*/`
    <style>
        #card {
            background-color: var(--grey-25);
        }
    </style>

    <div id="card">
        <div>
            <shift-card-title date="Sun Jan 15 2023 17:41:33 GMT+0100 (Mitteleuropäische Normalzeit)" route-name="Bla-Route"></shift-card-title>
        </div>
        <div>
            <shift-card-row></shift-card-row>
        </div>
        <div>
            <shift-card-button-edit language-code="en"></shift-card-button-edit>
        </div>
    </div>
`;

export default class ShiftCard extends HTMLElement {
    constructor() {
        super();

        /** @type {ShadowRoot} */
        this._shadowRoot = this.attachShadow({ mode: 'open' });
        this._shadowRoot.appendChild(template.content.cloneNode(true));
    }

    connectedCallback() {
        customElements.get('shift-card-title') || window.customElements.define('shift-card-title', ShiftCardTitle)
        customElements.get('shift-card-row') || window.customElements.define('shift-card-row', ShiftCardRow)
        customElements.get('shift-card-button-edit') || window.customElements.define('shift-card-button-edit', ShiftCardButtonEdit)
    }
}
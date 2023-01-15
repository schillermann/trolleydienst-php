"use strict"

import ShiftCard from "./shift-card.js"

const template = document.createElement('template');
template.innerHTML = /*html*/`
    <div id="calendar">
        <shift-card></shift-card>
        <shift-card></shift-card>
    </div>
`;

export default class ShiftCardCalendar extends HTMLElement {
    constructor() {
        super();

        /** @type {ShadowRoot} */
        this._shadowRoot = this.attachShadow({ mode: 'open' });
        this._shadowRoot.appendChild(template.content.cloneNode(true));
    }

    async connectedCallback() {
        const apiUrl = '/api/shift/shift-days-created'
        const response = await fetch(
            apiUrl,
            {
                method: 'GET',
                headers: { 'Content-Type': 'application/json' }
            }
        )
    
        if (response.status !== 200) {
            console.error('Cannot read shifts from api')
            return
        }

        const calendar = this._shadowRoot.getElementById("calendar")

        for (const shiftDay of await response.json()) {
            const shiftCard = document.createElement("shift-card")
            this._shadowRoot.appendChild(shiftCard)
        }

        customElements.get('shift-card') || window.customElements.define('shift-card', ShiftCard)
    }
}
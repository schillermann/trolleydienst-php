"use strict"

import CancelButton from "./cancel-button.js"
import CreateButton from "./create-button.js"

const template = document.createElement('template');
template.innerHTML = `
    <style>
        input {
            width: 100%;
        }
    </style>
    <dialog>
        <header>
            <h2>{New Shift}</h2>
        </header>
        <div>
            <div>
                <label for="route">Schichten <small>(Pflichtfeld)</small></label>
                <input id="route" name="route" required="" placeholder="Wie heißt die Route?">
            </div>
            <div>
                <label for="date_from">Datum <small>(Pflichtfeld)</small></label>
                <input id="date_from" type="date" name="date_from" required>
            </div>
            <div>
                <label for="time_from">Von <small>(Pflichtfeld)</small></label>
                <input id="time_from" type="time" name="time_from" required="" onchange="calculateShiftTimeTo()">
            </div>
            <div>
                <label for="number">Schichtanzahl <small>(Pflichtfeld)</small></label>
                <input id="number" type="number" name="number" required="" onchange="calculateShiftTimeTo()" value="2">
            </div>
            <div>
                <label for="hours_per_shift">Schichtlänge in Stunden <small>(Pflichtfeld)</small></label>
                <input id="hours_per_shift" type="number" name="hours_per_shift" required="" value="2" onchange="calculateShiftTimeTo()">
            </div>
            <div>
                <label for="time_to">Bis</label>
                <input id="time_to" type="time" name="time_to" disabled>
            </div>
            <div>
                <label for="shiftday_series_until">Terminserie bis zum</label>
                <input id="shiftday_series_until" type="date" name="shiftday_series_until">
            </div>
            <div>
                <label for="color_hex">Farbe</label>
                <input id="color_hex" type="color" name="color_hex" value="#d5c8e4" maxlength="7" required>
            </div>
        </div>
        <div>
            <div>
                <create-button label="Create"></create-button>
                <cancel-button label="Cancel"></cancel-button>
            </div>
        </div>
    </dialog>
`;

export default class CreateShiftDialog extends HTMLElement {
    constructor() {
        super();

        this._shadowRoot = this.attachShadow({ mode: 'open' })
        this._shadowRoot.appendChild(template.content.cloneNode(true))
    }

    closeDialog(event) {
        event.currentTarget.querySelector("dialog").close()
    }

    async connectedCallback() {
        customElements.get('create-button') || window.customElements.define('create-button', CreateButton)
        customElements.get('cancel-button') || window.customElements.define('cancel-button', CancelButton)

        this._shadowRoot.addEventListener(
            "cancel-click",
            this.closeDialog,
            true
        )
    }

    disconnectedCallback() {
        this._shadowRoot.removeEventListener(
            "click",
            this.closeDialog
        )
    }

    static get observedAttributes() {
        return ["open"];
    }
    
    attributeChangedCallback(name, oldVal, newVal) {
        if (name === "open") {
            const dialog = this._shadowRoot.querySelector("dialog")
            if (newVal === "true") {
                dialog.showModal()
                return
            }
            dialog.close()
            return
        }
    }
}
"use strict"

import ShiftDialogButtonCancel from "./shift-dialog-button-cancel.js"
import ShiftDialogButtonCreate from "./shift-dialog-button-create.js"
import Dictionary from "../../dictionary.js"

const template = document.createElement('template');
template.innerHTML = /*html*/`
    <style>
        input {
            width: 100%;
        }
    </style>
    <dialog>
        <header>
            <h2>{Create Shift}</h2>
        </header>
        <div>
            <div>
                <label for="route">{Route} <small>({Required})</small></label>
                <input id="route" name="route" required placeholder="{Wie heißt die Route?}">
            </div>
            <div>
                <label for="date_from">{Date} <small>({Required})</small></label>
                <input id="date_from" type="date" name="date_from" required>
            </div>
            <div>
                <label for="time_from">{From} <small>({Required})</small></label>
                <input id="time_from" type="time" name="time_from" required onchange="calculateShiftTimeTo()">
            </div>
            <div>
                <label for="number">{Shifts} <small>({Required})</small></label>
                <input id="number" type="number" name="number" required onchange="calculateShiftTimeTo()" value="2">
            </div>
            <div>
                <label for="hours_per_shift">{Shift Length in Hours} <small>({Required})</small></label>
                <input id="hours_per_shift" type="number" name="hours_per_shift" required="" value="2" onchange="calculateShiftTimeTo()">
            </div>
            <div>
                <label for="time_to">{To}</label>
                <input id="time_to" type="time" name="time_to" disabled>
            </div>
            <div>
                <label for="shiftday_series_until">{End Date}</label>
                <input id="shiftday_series_until" type="date" name="shiftday_series_until">
            </div>
            <div>
                <label for="color_hex">{Colour}</label>
                <input id="color_hex" type="color" name="color_hex" value="#d5c8e4" maxlength="7" required>
            </div>
        </div>
        <div>
            <input type="hidden" id="shift_type_id" name="shift_type_id" />
            <shift-dialog-button-create></shift-dialog-button-create>
            <shift-dialog-button-cancel></shift-dialog-button-cancel>
        </div>
    </dialog>
`;

export default class ShiftDialogNewShift extends HTMLElement {
    constructor() {
        super();

        this._shadowRoot = this.attachShadow({ mode: 'open' })
        this._shadowRoot.appendChild(template.content.cloneNode(true))

        this.dictionary = new Dictionary({
            "Create Shift": {
                de: "Schicht Anlegen"   
            },
            "Required": {
                de: "Pflichtfeld"
            },
            "Route": {
                de: "Route"
            },
            "Date": {
                de: "Datum"
            },
            "From" : {
                de: "Von"
            },
            "Shifts" : {
                de: "Schichten"
            },
            "Shift Length in Hours": {
                de: "Schichtlänge in Stunden"
            },
            "What is the name of this location?": {
                de: "Wie heißt die Route?"
            },
            "To": {
                de: "Bis"
            },
            "End Date": {
                de: "Terminserie bis zum"
            },
            "Colour": {
                de: "Farbe"
            }
        })
    }

    closeDialog(event) {
        event.currentTarget.querySelector("dialog").close()
    }

    async createShift(event) {
        const response = await fetch(
            "/api/shift/create-shifts",
            {
                method: 'POST',
                body: JSON.stringify({
                    "startDate": event.currentTarget.querySelector("input#date_from").value + " " + event.currentTarget.querySelector("input#time_from").value,
                    "shiftTypeId": event.currentTarget.querySelector("input#shift_type_id").value,
                    "routeName": event.currentTarget.querySelector("input#route").value,
                    "numberOfShifts": event.currentTarget.querySelector("input#number").value,
                    "minutesPerShift": event.currentTarget.querySelector("input#hours_per_shift").value * 60,
                    "color": event.currentTarget.querySelector("input#color_hex").value
                })
            }
        )

        if (response.status === 201) {
            event.target._shadowRoot.querySelector("dialog").close()
        }
    }

    async connectedCallback() {
        customElements.get('shift-dialog-button-create') || window.customElements.define('shift-dialog-button-create', ShiftDialogButtonCreate)
        customElements.get('shift-dialog-button-cancel') || window.customElements.define('shift-dialog-button-cancel', ShiftDialogButtonCancel)

        this._shadowRoot.addEventListener(
            "cancel-action",
            this.closeDialog,
            true
        )

        this._shadowRoot.addEventListener(
            "create-click",
            (event) => { this.createShift(event) },
            true
        )
    }

    disconnectedCallback() {
        this._shadowRoot.removeEventListener(
            "click",
            this.closeDialog
        )

        this._shadowRoot.removeEventListener(
            "click",
            this.createShift
        )
    }

    static get observedAttributes() {
        return ["open", "language-code", "shift-type-id"];
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

        if (name === "language-code") {
            this._shadowRoot.querySelector("shift-dialog-button-create").setAttribute("language-code", newVal)
            this._shadowRoot.querySelector("shift-dialog-button-cancel").setAttribute("language-code", newVal)

            this._shadowRoot.innerHTML = this.dictionary.innerHTMLEnglishTo(newVal, this._shadowRoot.innerHTML)
            return
        }

        if (name === "shift-type-id") {
            this._shadowRoot.querySelector("input#shift_type_id").value = newVal
        }
    }
}
"use strict"

import DialogButton from "../../dialog/button.js"
import DialogButtonPrimary from "../../dialog/button-primary.js"
import Dictionary from "../../dictionary.js"

const template = document.createElement('template');
template.innerHTML = `
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
                <label for="number_of_shifts">{Shifts} <small>({Required})</small></label>
                <input id="number_of_shifts" type="number" name="number_of_shifts" required onchange="calculateShiftTimeTo()" value="2">
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
            <dialog-button-primary id="button-create">{Create}</dialog-button-primary>
            <dialog-button id="button-cancel">{Cancel}</dialog-button>
        </div>
    </dialog>
`;
// TODO: implement calculateShiftTimeTo function
export default class ShiftDialogNewShift extends HTMLElement {
  #shiftTypeId
    constructor() {
        super();

      this.#shiftTypeId = 0
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
            },
            "Create": {
                de: "Anlegen"   
            },
            "Cancel": {
                de: "Abbrechen"   
            }
        })
    }

    /**
     * @param {Event} event
     * @returns {void}
     */
    onClickButtonCancel(event) {
      this.setAttribute("open", "false")
    }

    /**
     * @param {Event} event
     * @returns {void}
     */
    async onClickButtonCreate(event) {
      console.log(this._shadowRoot.getElementById("time_from").value)
        const response = await fetch(
          "/api/shift/create-shifts",
          {
            method: "POST", body: JSON.stringify({
              "startDate": this._shadowRoot.getElementById("date_from").value + " " + this._shadowRoot.getElementById("time_from").value,
              "shiftTypeId": this.#shiftTypeId,
              "routeName": this._shadowRoot.getElementById("route").value,
              "numberOfShifts": Number(this._shadowRoot.getElementById("number_of_shifts").value),
              "minutesPerShift": this._shadowRoot.getElementById("hours_per_shift").value * 60,
              "color": this._shadowRoot.getElementById("color_hex").value
            })
          }
        )

        if (response.status === 201) {
          this.setAttribute("open", "false")
        }
    }

    async connectedCallback() {
      customElements.get('dialog-button-primary') || window.customElements.define('dialog-button-primary', DialogButtonPrimary)
      customElements.get('dialog-button') || window.customElements.define('dialog-button', DialogButton)

      this._shadowRoot.getElementById("button-cancel").addEventListener(
        "click",
        this.onClickButtonCancel.bind(this)
      )

      this._shadowRoot.getElementById("button-create").addEventListener(
        "click",
        this.onClickButtonCreate.bind(this)
      )
    }

    disconnectedCallback() {
      this._shadowRoot.getElementById("button-cancel").removeEventListener(
        "click",
        this.onClickButtonCancel
      )

      this._shadowRoot.getElementById("button-create").removeEventListener(
        "click",
        this.onClickButtonCreate
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
            this._shadowRoot.innerHTML = this.dictionary.innerHTMLEnglishTo(newVal, this._shadowRoot.innerHTML)
            return
        }

        if (name === "shift-type-id") {
          this.#shiftTypeId = Number(newVal)
        }
    }
}

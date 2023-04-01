"use strict"

import ShiftDialogButtonApply from "./shift-dialog-button-apply.js"
import ShiftDialogButtonCancel from "./shift-dialog-button-cancel.js"
import Dictionary from "../../dictionary.js"
import ShiftDialogSelectmenuPublishers from "./shift-dialog-selectmenu-publishers.js"

const template = document.createElement('template');
template.innerHTML = /*html*/`
    <style></style>
    <dialog>
        <header>
            <h2>{Shift Application}</h2>
        </header>
        <div>
            <img src="images/gadgets.svg">
        </div>
        <div>
            <input type="hidden" id="shift_day_id" name="shift_day_id" />
            <input type="hidden" id="shift_id" name="shift_id" />
            <input type="hidden" id="publisher_id" name="publisher_id" />
            <shift-dialog-selectmenu-publishers></shift-dialog-selectmenu-publishers>
            <shift-dialog-button-apply></shift-dialog-button-apply>
            <shift-dialog-button-cancel></shift-dialog-button-cancel>
        </div>
    </dialog>
`;

export default class ShiftDialogApplication extends HTMLElement {
    constructor() {
        super();

        this._shadowRoot = this.attachShadow({ mode: 'open' })
        this._shadowRoot.appendChild(template.content.cloneNode(true))

        this.dictionary = new Dictionary({
            "Shift Application": {
                de: "Schicht Bewerbung"   
            }
        })
    }

    closeDialog(event) {
        event.currentTarget.querySelector("dialog").close()
    }

    async sendShiftApplication(event) {
        // TODO: Endpoint gibt Fehler zurueck
        const response = await fetch(
            "/api/shift/register-publisher-for-shift",
            {
                method: 'POST',
                body: JSON.stringify({
                    shiftDayId: event.currentTarget.querySelector("input#shift_day_id").value,
                    shiftId: event.currentTarget.querySelector("input#shift_id").value,
                    publisherId: event.currentTarget.querySelector("input#publisher_id").value
                })
            }
        )

        if (response.status === 201) {
            event.target._shadowRoot.querySelector("dialog").close()
        }
    }

    setPublisherId(event) {
        event.currentTarget.querySelector("input#publisher_id").value = event.detail.publisherId
    }

    connectedCallback() {
        customElements.get('shift-dialog-button-apply') || window.customElements.define('shift-dialog-button-apply', ShiftDialogButtonApply)
        customElements.get('shift-dialog-button-cancel') || window.customElements.define('shift-dialog-button-cancel', ShiftDialogButtonCancel) 
        customElements.get('shift-dialog-selectmenu-publishers') || window.customElements.define('shift-dialog-selectmenu-publishers', ShiftDialogSelectmenuPublishers)

        this._shadowRoot.addEventListener(
            "selectmenu-change",
            this.setPublisherId,
            true
        )

        this._shadowRoot.addEventListener(
            "apply-shift",
            this.sendShiftApplication,
            true
        )

        this._shadowRoot.addEventListener(
            "cancel-action",
            this.closeDialog,
            true
        )
    }

    disconnectedCallback() {
        this._shadowRoot.removeEventListener(
            "selectmenu-change",
            this.setPublisherId
        )

        this._shadowRoot.removeEventListener(
            "click",
            this.closeDialog
        )

        this._shadowRoot.removeEventListener(
            "click",
            this.sendShiftApplication
        )
    }

    static get observedAttributes() {
        return ["open", "language-code", "shift-day-id", "shift-id", "publisher-id"];
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
            this._shadowRoot.querySelector("shift-dialog-button-apply").setAttribute("language-code", newVal)
            this._shadowRoot.querySelector("shift-dialog-button-cancel").setAttribute("language-code", newVal)

            this._shadowRoot.innerHTML = this.dictionary.innerHTMLEnglishTo(newVal, this._shadowRoot.innerHTML)
            return
        }

        if (name === "shift-day-id") {
            this._shadowRoot.querySelector("input#shift_day_id").value = newVal
            return
        }

        if (name === "shift-id") {
            this._shadowRoot.querySelector("input#shift_id").value = newVal
            return
        }

        if (name === "publisher-id") {
            this._shadowRoot.querySelector("shift-dialog-selectmenu-publishers").setAttribute("publisher-id", newVal)
            this._shadowRoot.querySelector("input#publisher_id").value = newVal
            return
        }
    }
}
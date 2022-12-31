"use strict"

import ApplyButton from "./apply-button.js"
import CancelButton from "./cancel-button.js"

const template = document.createElement('template');
template.innerHTML = `
    <style>
        button {
            width: 100%;
        }
    </style>
    <dialog>
        <header>
            <h2>{APPLY}</h2>
        </header>
        <div>
            <img src="images/gadgets.svg">
        </div>
        <div>
            <select style="width: 100%"></select>
            <apply-button label="Apply"></apply-button>
            <cancel-button label="Cancel"></cancel-button>
        </div>
    </dialog>
`;

export default class DialogApplyShift extends HTMLElement {
    constructor() {
        super();

        this._shadowRoot = this.attachShadow({ mode: 'open' })
        this._shadowRoot.appendChild(template.content.cloneNode(true))
    }

    closeDialog(event) {
        event.currentTarget.querySelector("dialog").close()
    }

    async sendShiftApplication(event) {
        const response = await fetch(
            "/api/shift/register-publisher-for-shift",
            {
                method: 'POST',
                body: JSON.stringify(credentials)
            }
        )

        if (response.status === 201) {
            event.currentTarget.querySelector("dialog").close()
        }
    }

    async connectedCallback() {
        const response = await fetch(
            "/api/shift/publishers-enabled"
        )

        for (const applicant of await response.json()) {
            const select = this._shadowRoot.querySelector("select")
            const option = document.createElement('option');
            option.value = applicant.id;
            option.innerHTML = applicant.name;
            select.appendChild(option);
        }

        window.customElements.define('apply-button', ApplyButton)
        window.customElements.define('cancel-button', CancelButton)
        
        this._shadowRoot.addEventListener(
            "apply-click",
            this.sendShiftApplication,
            true
        )

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

        this._shadowRoot.removeEventListener(
            "click",
            this.sendShiftApplication
        )
    }

    static get observedAttributes() {
        return ["open", "title", "label-button-cancel"];
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
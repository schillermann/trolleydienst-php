"use strict"

import ApplyButton from "./apply-button.js"
import CancelButton from "./cancel-button.js"
import Dictionary from "../../dictionary.js"
import PublishersSelect from "./publishers-select.js"

const template = document.createElement('template');
template.innerHTML = `
    <style></style>
    <dialog>
        <header>
            <h2>Shift Application</h2>
        </header>
        <div>
            <img src="images/gadgets.svg">
        </div>
        <div>
            <publishers-select></publishers-select>
            <apply-button></apply-button>
            <cancel-button></cancel-button>
        </div>
    </dialog>
`;

export default class ApplyShiftDialog extends HTMLElement {
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

    connectedCallback() {
        customElements.get('apply-button') || window.customElements.define('apply-button', ApplyButton)
        customElements.get('cancel-button') || window.customElements.define('cancel-button', CancelButton) 
        customElements.get('publishers-select') || window.customElements.define('publishers-select', PublishersSelect)
        
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
        return ["open", "language-code"];
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
            this._shadowRoot.querySelector("apply-button").setAttribute("language-code", newVal)
            this._shadowRoot.querySelector("cancel-button").setAttribute("language-code", newVal)

            const title = this._shadowRoot.querySelector("dialog header h2")
            title.textContent = this.dictionary.englishTo(newVal, title.textContent)
            return
        }
    }
}
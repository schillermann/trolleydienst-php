"use strict"

import ShiftDialogButtonClose from "./shift-dialog-button-close.js"

const template = document.createElement('template');
template.innerHTML = /*html*/`
    <style>
        input {
            width: 100%;
        }
    </style>
    <dialog>
        <header>
            <h2>{Shift}</h2>
        </header>
        <div>
            <p>Publisher Partner</p>
        </div>
        <div>
            <shift-dialog-button-close language-code="en"></shift-dialog-button-close>
        </div>
    </dialog>
`;

export default class ShiftDialogPublisherPartner extends HTMLElement {
    constructor() {
        super();

        this._shadowRoot = this.attachShadow({ mode: 'open' })
        this._shadowRoot.appendChild(template.content.cloneNode(true))
    }

    closeDialog(event) {
        event.currentTarget.querySelector("dialog").close()
    }

    connectedCallback() {
        customElements.get('shift-dialog-button-close') || window.customElements.define('shift-dialog-button-close', ShiftDialogButtonClose)

        this._shadowRoot.addEventListener(
            "close-dialog",
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
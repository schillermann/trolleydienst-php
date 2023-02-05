"use strict"

import ShiftCardTime from "./shift-card-time.js"
import ShiftCardButtonAddPublisher from "./shift-card-button-add-publisher.js"
import ShiftCardButtonApply from "./shift-card-button-apply.js"

const template = document.createElement('template');
template.innerHTML = /*html*/`
    <dl>          
        <dt>
            <shift-card-time></shift-card-time>
        </dt>
        <dd>
            <shift-card-button-apply language-code="en"></shift-card-button-apply>
            <shift-card-button-apply language-code="en"></shift-card-button-apply>
            <shift-card-button-apply language-code="en"></shift-card-button-apply>
            <shift-card-button-add-publisher></shift-card-button-add-publisher>
        </dd>
    </dl>
`;

export default class ShiftCardRow extends HTMLElement {
    constructor() {
        super();

        /** @type {ShadowRoot} */
        this._shadowRoot = this.attachShadow({ mode: 'open' });
        this._shadowRoot.appendChild(template.content.cloneNode(true));
    }

    /**
     * @param {Event} event
     * @returns {void}
     */
    fireOpenShiftDialogApplicationEvent(event) {
        this.dispatchEvent(
            new CustomEvent(
                'open-shift-dialog-application-click', {
                    bubbles: true,
                    composed: true,
                    detail: {
                        shiftDayId: 1,
                        shiftId: 2
                    }
                }
            )
        )
    }

    connectedCallback() {
        const shiftCardTime = this._shadowRoot.querySelector("shift-card-time")
        shiftCardTime.setAttribute("date-from", new Date().toString())
        shiftCardTime.setAttribute("date-to", new Date().toString())

        customElements.get('shift-card-time') || window.customElements.define('shift-card-time', ShiftCardTime)
        customElements.get('shift-card-button-apply') || window.customElements.define('shift-card-button-apply', ShiftCardButtonApply)
        customElements.get('shift-card-button-add-publisher') || window.customElements.define('shift-card-button-add-publisher', ShiftCardButtonAddPublisher)

        this.addEventListener("apply-shift-click", this.fireOpenShiftDialogApplicationEvent, true)
    }
}
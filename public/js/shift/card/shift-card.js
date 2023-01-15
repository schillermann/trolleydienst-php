"use strict"

import ShiftCardTitle from "./shift-card-title.js"
import ShiftCardTime from "./shift-card-time.js"
import ShiftCardButtonAddPublisher from "./shift-card-button-add-publisher.js"
import ShiftCardButtonApply from "./shift-card-button-apply.js"
import ShiftCardButtonEdit from "./shift-card-button-edit.js"

const template = document.createElement('template');
template.innerHTML = /*html*/`
    <style>
        table {
            width: 100%;
            margin-top: 20px;
        }
    </style>
    <table>
        <thead>
            <tr>
                <th colspan="2" style="background-color: red">
                    <shift-card-title date="Sun Jan 15 2023 17:41:33 GMT+0100 (Mitteleuropäische Normalzeit)" route-name="Bla-Route"></shift-card-title>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td id="time">
                    <shift-card-time></shift-card-time>
                </td>
                <td class="shift-publishers">
                    <shift-card-button-apply language-code="en"></shift-card-button-apply>
                    <shift-card-button-apply language-code="en"></shift-card-button-apply>
                    <shift-card-button-apply language-code="en"></shift-card-button-apply>
                    <shift-card-button-add-publisher></shift-card-button-add-publisher>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="background-color: red">
                    <!-- if admin -->
                    <shift-card-button-edit language-code="en"></shift-card-button-edit>
                </td>
            </tr>
        </tfoot>
    </table>
`;

export default class ShiftCard extends HTMLElement {
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
    fireOpenShiftApplicationDialogEvent(event) {
        this.dispatchEvent(
            new Event(
                'open-shift-applicationt-dialog-click', {
                    bubbles: true,
                    composed: true
                }
            )
        )
    }

    connectedCallback() {
        this._shadowRoot.querySelector("shift-card-time").setAttribute("date-from", new Date().toString())
        this._shadowRoot.querySelector("shift-card-time").setAttribute("date-to", new Date().toString())

        customElements.get('shift-card-title') || window.customElements.define('shift-card-title', ShiftCardTitle)
        customElements.get('shift-card-time') || window.customElements.define('shift-card-time', ShiftCardTime)
        customElements.get('shift-card-button-apply') || window.customElements.define('shift-card-button-apply', ShiftCardButtonApply)
        customElements.get('shift-card-button-add-publisher') || window.customElements.define('shift-card-button-add-publisher', ShiftCardButtonAddPublisher)
        customElements.get('shift-card-button-edit') || window.customElements.define('shift-card-button-edit', ShiftCardButtonEdit)

        this.addEventListener("apply-shift-click", this.fireOpenShiftApplicationDialogEvent, true)
    }
}
"use strict"

import Dictionary from "../../dictionary.js"

const template = document.createElement('template');
template.innerHTML = /*html*/`
    <style>
        @import url("css/font-awesome.min.css");

        button {
            transition: box-shadow .28s;
            padding: 6px 12px;
            line-height: 1.42857143;
            font-size: 1rem;
            vertical-align: middle;
            touch-action: manipulation;
            cursor: pointer;
            user-select: none;
            border: 1px solid rgba(189, 183, 181, 0.5);
            color: var(--black);
            margin-bottom: 4px;
            background-color: var(--grey-25);
            border-radius: 5px;
            width: 180px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        button:hover {
            background-color: var(--second-color);
            border-color: var(--second-color);
            background-color: var(--grey-25);
        }

        @media (prefers-color-scheme: dark) {
            button {
                color: var(--white);
            }
        }
    </style>
    <button class="button promote apply-shift-button" type="button">
        <i class="fa fa-hand-o-right"></i> {Available}
    </button>
`;

export default class ShiftCardButtonApply extends HTMLElement {
    constructor() {
        super();

        /** @type {ShadowRoot} */
        this._shadowRoot = this.attachShadow({ mode: 'open' });
        this._shadowRoot.appendChild(template.content.cloneNode(true));

        this.dictionary = new Dictionary({
            "Available": {
                de: "Frei"   
            }
        })
    }

    /**
     * @param {Event} event
     * @returns {void}
     */
    fireApplyShiftEvent(event) {
        this.dispatchEvent(
            new Event(
                'apply-shift-click', {
                    bubbles: true,
                    composed: true
                }
            )
        )
    }

    /**
     * @returns {void}
     */
    connectedCallback() {
        this._shadowRoot.querySelector("button").addEventListener(
            "click",
            this.fireApplyShiftEvent,
            true
        )
    }

    static get observedAttributes() {
        return ["language-code"];
    }

    attributeChangedCallback(name, oldVal, newVal) {
        if (name !== "language-code") {
            return
        }

        this._shadowRoot.innerHTML = this.dictionary.innerHTMLEnglishTo(newVal, this._shadowRoot.innerHTML)
    }
}
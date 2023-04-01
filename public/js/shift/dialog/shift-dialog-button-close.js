"use strict"

import Dictionary from "../../dictionary.js"

const template = document.createElement('template');
template.innerHTML = /*html*/`
    <style>
        button {
            width: 100%;
        }
    </style>
    <button>{Close}</button>
`;

export default class ShiftDialogButtonClose extends HTMLElement {
    constructor() {
        super();

        /** @type {ShadowRoot} */
        this._shadowRoot = this.attachShadow({ mode: 'open' });
        this._shadowRoot.appendChild(template.content.cloneNode(true));

        this.dictionary = new Dictionary({
            "Close": {
                de: "Schliessen"   
            }
        })
    }

    /**
     * @param {Event} event
     * @returns {void}
     */
    fireClickEvent(event) {
        this.dispatchEvent(
            new Event(
                'close-dialog', {
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
            this.fireClickEvent,
            true
        )
    }

    /**
     * @returns {void}
     */
    disconnectedCallback() {
        this._shadowRoot.querySelector("button").removeEventListener(
            "click",
            this.fireClickEvent
        )
    }

    static get observedAttributes() {
        return ["language-code"];
    }
    
    /**
     * @param {string} name 
     * @param {string} oldVal 
     * @param {string} newVal 
     * @returns {void}
     */
    attributeChangedCallback(name, oldVal, newVal) {
        if (name !== "language-code") {
            return
        }

        this._shadowRoot.innerHTML = this.dictionary.innerHTMLEnglishTo(newVal, this._shadowRoot.innerHTML)
    }
}
"use strict"

import Dictionary from "../../dictionary.js"

const template = document.createElement('template');
template.innerHTML = `
    <style>
        button {
            width: 100%;
        }
    </style>
    <button>Cancel</button>
`;

export default class CancelButton extends HTMLElement {
    constructor() {
        super();

        /** @type {ShadowRoot} */
        this._shadowRoot = this.attachShadow({ mode: 'open' });
        this._shadowRoot.appendChild(template.content.cloneNode(true));

        this.dictionary = new Dictionary({
            "Cancel": {
                de: "Abbrechen"   
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
                'cancel-click', {
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

        const button = this._shadowRoot.querySelector("button")
        button.textContent = this.dictionary.englishTo(newVal, button.textContent)
    }
}
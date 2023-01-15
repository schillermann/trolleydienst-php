"use strict"

const template = document.createElement('template');
template.innerHTML = /*html*/`
    <style>
        h2 {
            text-align: left;
        }
    </style>
    <h2>
        <span id="date">Date</span> - <span id="route-name">Route Name</span>
    </h2>
`;

export default class ShiftCardTitle extends HTMLElement {
    constructor() {
        super();

        /** @type {ShadowRoot} */
        this._shadowRoot = this.attachShadow({ mode: 'open' });
        this._shadowRoot.appendChild(template.content.cloneNode(true));
    }

    /**
     * @returns {Array}
     */
    static get observedAttributes() {
        return ["date", "route-name"];
    }

    /**
     * 
     * @param {string} name attribute name
     * @param {string} oldVal 
     * @param {string} newVal 
     * @returns 
     */
    attributeChangedCallback(name, oldVal, newVal) {
        if (name === "date") {
            this._shadowRoot.querySelector("#date").innerText = new Date(newVal).toDateString()
            return
        }

        if (name === "route-name") {
            this._shadowRoot.querySelector("#route-name").innerText = newVal
        }
    }
}
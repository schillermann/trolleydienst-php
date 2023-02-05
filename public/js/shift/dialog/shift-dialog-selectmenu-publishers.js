"use strict"

const template = document.createElement('template');
template.innerHTML = /*html*/`
    <select style="width: 100%"></select>
`;

export default class ShiftDialogSelectmenuPublishers extends HTMLElement {
    constructor() {
        super();

        /** @type {ShadowRoot} */
        this._shadowRoot = this.attachShadow({ mode: 'open' });
        this._shadowRoot.appendChild(template.content.cloneNode(true));

    }

    fireChangeEvent(event) {
        this.dispatchEvent(
            new CustomEvent(
                'selectmenu-change', {
                    bubbles: true,
                    composed: true,
                    detail: {
                        publisherId: event.target.value
                    }
                }
            )
        )
    }

    /**
     * @returns {void}
     */
    connectedCallback() {
        this._shadowRoot.querySelector("select").addEventListener(
            "change",
            this.fireChangeEvent,
            true
        )
    }

    /**
     * @returns {void}
     */
    disconnectedCallback() {
        this._shadowRoot.querySelector("select").removeEventListener(
            "change",
            this.fireChangeEvent
        )
    }

    static get observedAttributes() {
        return ["publisher-id"];
    }
    
    /**
     * @param {string} name 
     * @param {string} oldVal 
     * @param {string} newVal 
     * @returns {void}
     */
    async attributeChangedCallback(name, oldVal, newVal) {
        if (name !== "publisher-id") {
            return
        }

        const response = await fetch(
            "/api/shift/publishers-enabled"
        )

        for (const publisher of await response.json()) {
            const select = this._shadowRoot.querySelector("select")
            const option = document.createElement('option');
            option.value = publisher.id;
            option.innerHTML = publisher.name;
            if (publisher.id == newVal) {
                option.setAttribute('selected', 'selected')
            }
            select.appendChild(option);
        }
    }
}
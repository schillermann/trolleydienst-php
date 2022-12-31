"use strict"

const template = document.createElement('template');
template.innerHTML = `
    <select style="width: 100%"></select>
`;

export default class PublishersSelect extends HTMLElement {
    constructor() {
        super();

        /** @type {ShadowRoot} */
        this._shadowRoot = this.attachShadow({ mode: 'open' });
        this._shadowRoot.appendChild(template.content.cloneNode(true));

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
    }
}
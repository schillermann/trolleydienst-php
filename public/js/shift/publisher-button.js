"use strict"

export default class PublisherButton {
    #template

    /**
     * @param {Element} template
     */
    constructor(template) {
        this.#template = template
    }

    /**
     * @param {string} firstname
     * @param {string} lastname
     * @returns {Node}
     */
    node(firstname, lastname) {
        const cloneNode = this.#template.content.cloneNode(true)

        const button = cloneNode.querySelector("button")
        button.innerHTML = button.innerHTML.replace(/{FIRSTNAME}/i, firstname)
        button.innerHTML = button.innerHTML.replace(/{LASTNAME}/i, lastname)

        return cloneNode
    }
}
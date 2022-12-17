"use strict"

export default class PublisherButton {
    /**
     * @param {Element} template
     */
    constructor(template) {
        this.template = template
    }

    /**
     * @param {string} firstname
     * @param {string} lastname
     * @returns {Node}
     */
    node(firstname, lastname) {
        const cloneNode = this.template.content.cloneNode(true)

        const button = cloneNode.querySelector("button")
        button.textContent = button.textContent.replace(/{FIRSTNAME}/i, firstname)
        button.textContent = button.textContent.replace(/{LASTNAME}/i, lastname)

        return cloneNode
    }
}
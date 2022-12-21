"use strict"

export default class ShiftRow {
    #template
    #publisherButton
    #bookingButton
    #additionPublisherButton

    /**
     * @param {Element} template
     * @param {import("./publisher-button").default} publisherButton
     * @param {import("./booking-button").default} bookingButton
     * @param {import("./addition-publisher-button").default} additionPublisherButton
     */
    constructor(template, publisherButton, bookingButton, additionPublisherButton) {
        this.#template = template
        this.#publisherButton = publisherButton
        this.#bookingButton = bookingButton
        this.#additionPublisherButton = additionPublisherButton
    }

    /**
     * @param {[]} publishers
     * @param {number} publisherLimit
     * @returns {Node}
     */
    node(publishers, publisherLimit) {
        const cloneNode =  this.#template.content.cloneNode(true)
        const row = cloneNode.querySelector(".shift-publishers")

        for (const publisher of publishers) {
            row.appendChild(this.#publisherButton.node(publisher.firstname, publisher.lastname))
        }

        for (let i = publishers.length; i < publisherLimit; i++) {
            row.appendChild(this.#bookingButton.node())
        }

        row.appendChild(this.#additionPublisherButton.node())

        return cloneNode
    }
}
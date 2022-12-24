"use strict"

export default class ShiftRow {
    #template
    #publisherButton
    #applyButton
    #additionPublisherButton

    /**
     * @param {Element} template
     * @param {import("./publisher-button").default} publisherButton
     * @param {import("./booking-button").default} applyButton
     * @param {import("./addition-publisher-button").default} additionPublisherButton
     */
    constructor(template, publisherButton, applyButton, additionPublisherButton) {
        this.#template = template
        this.#publisherButton = publisherButton
        this.#applyButton = applyButton
        this.#additionPublisherButton = additionPublisherButton
    }

    /**
     * @param {number} shiftDayId
     * @param {number} shiftId
     * @param {number} publisherLimit
     * @param {[]} publishers
     * @returns {Node}
     */
    node(shiftDayId, shiftId, publisherLimit, publishers) {
        const cloneNode =  this.#template.content.cloneNode(true)
        const row = cloneNode.querySelector(".shift-publishers")

        for (const publisher of publishers) {
            row.appendChild(this.#publisherButton.node(publisher.firstname, publisher.lastname))
        }

        for (let i = publishers.length; i < publisherLimit; i++) {
            row.appendChild(this.#applyButton.node(shiftDayId, shiftId))
        }

        row.appendChild(this.#additionPublisherButton.node())

        return cloneNode
    }
}
"use strict"

export default class ShiftApi {
    /**
     * @param {string} endpoint 
     * @param {Date} startDate
     * @param {number} shiftTypeId
     * @param {number} pageItems
     */
    constructor(endpoint, startDate, shiftTypeId, pageItems) {
        this.endpoint = endpoint
        this.startDate = startDate
        this.shiftTypeId = shiftTypeId
        this.pageItems = pageItems
    }

    /**
     * 
     * @param {number} pageNumber 
     * @returns {Object}
     */
    async shiftDays(pageNumber) {
        return (await fetch(
            this.endpoint +
            "?start-date=" + this.startDate.toISOString().split('T')[0] +
            "&shift-type-id=" + this.shiftTypeId +
            "&page-number=" + pageNumber +
            "&page-items=" + this.pageItems
        )).json();
    }
}
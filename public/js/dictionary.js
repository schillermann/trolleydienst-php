"use strict"

export default class Dictionary {

    #translation

    /**
     * @example
     * {
     *   "English": {
     *     de: "Deutsch"   
     *   }
     * }
     * @param {Object} translation 
     */
    constructor(translation) {
        this.#translation = translation
    }

    /**
     * 
     * @param {("en"|"de")} languageCode 
     * @param {string} text 
     * @returns {string}
     */
    englishTo(languageCode, text) {
        if (this.#translation[text] === undefined || this.#translation[text][languageCode] === undefined) {
            return text
        }

        return this.#translation[text][languageCode]
    }
}
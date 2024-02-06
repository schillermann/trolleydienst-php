"use strict";

export class Dictionary {
  #translation;

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
    this.#translation = translation;
  }

  /**
   *
   * @param {("en"|"de")} languageCode
   * @param {string} innerHTML
   * @param {string} text
   * @returns {string} innerHTML
   */
  innerHTMLEnglishTo(languageCode, innerHTML) {
    const matches = innerHTML.match(/(?<=\{).*?(?=\})/g);
    for (const text of matches) {
      if (
        this.#translation[text] === undefined ||
        this.#translation[text][languageCode] === undefined
      ) {
        innerHTML = innerHTML.replace("{" + text + "}", text);
        continue;
      }

      innerHTML = innerHTML.replace(
        "{" + text + "}",
        this.#translation[text][languageCode],
      );
    }
    return innerHTML;
  }
}

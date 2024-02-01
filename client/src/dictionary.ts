"use strict";

export class Dictionary {
  translation?: {[key: string]: {[key: string]: string}};

  /**
   * @example
   * {
   *   "English": {
   *     de: "Deutsch"
   *   }
   * }
   */
  constructor(translation?: {[key: string]: {[key: string]: string}}) {
    this.translation = translation;
  }

  innerHTMLEnglishTo(languageCode: string, innerHTML: string): string {
    const matches = innerHTML.match(/(?<=\{).*?(?=\})/g);
    for (const text of matches) {
      if (
        this.translation[text] === undefined ||
        this.translation[text][languageCode] === undefined
      ) {
        innerHTML = innerHTML.replace("{" + text + "}", text);
        continue;
      }

      innerHTML = innerHTML.replace(
        "{" + text + "}",
        this.translation[text][languageCode],
      );
    }
    return innerHTML;
  }
}

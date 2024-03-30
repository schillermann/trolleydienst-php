const language = (window.navigator.language || "en").split("-")[0];
let translationList = {};
if (language !== "en") {
  translationList = await (
    await fetch(`/api/languages/${language.toLowerCase()}.json`)
  ).json();
}

/**
 * @param {string} text
 * @returns {string} translation
 */
export function translate(text) {
  const translation = translationList[text];
  if (translation) {
    return translation;
  }
  return text;
}

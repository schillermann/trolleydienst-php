export class FrontierElement extends HTMLElement {
  constructor() {
    super();

    this.attachShadow({ mode: "open" });
  }

  /**
   * @param {string} name
   * @param {string} oldVal
   * @param {string} newVal
   */
  attributeChangedCallback(name, oldVal, newVal) {
    if (oldVal === newVal || oldVal === null) {
      return;
    }

    this.render();
  }

  render() {
    const templateString = this.template();
    if (templateString.length === 0) {
      return;
    }

    const template = document.createElement("template");
    template.innerHTML = templateString;
    this.shadowRoot.replaceChildren();
    this.shadowRoot.appendChild(template.content.cloneNode(true));
  }

  /**
   * @returns {string}
   */
  template() {
    return "";
  }
}

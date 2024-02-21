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
  async attributeChangedCallback(name, oldVal, newVal) {
    if (oldVal === newVal || oldVal === null) {
      return;
    }

    await this.renderTemplate();
  }

  /**
   * @returns {Promise<void>}
   */
  async connectedCallback() {
    await this.renderTemplate();
  }

  /**
   * @returns {Promise<void>}
   */
  async renderTemplate() {
    const templateString = await this.template();
    if (templateString.length === 0) {
      return;
    }

    const template = document.createElement("template");
    template.innerHTML = templateString;
    this.shadowRoot.replaceChildren();
    this.shadowRoot.appendChild(template.content.cloneNode(true));
  }

  /**
   * @returns {Promise<string>}
   */
  async template() {
    return "";
  }
}

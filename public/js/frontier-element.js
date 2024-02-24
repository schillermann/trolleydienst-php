export class FrontierElement extends HTMLElement {
  #templateCache;

  constructor() {
    super();

    this.#templateCache = "";
    this.attachShadow({ mode: "open" });
  }

  /**
   * @returns {string}
   */
  debug() {
    return this.getAttribute("debug") === "true";
  }

  /**
   * @param {string} name
   * @param {string} oldVal
   * @param {string} newVal
   */
  async attributeChangedCallback(name, oldVal, newVal) {
    if (this.debug()) {
      console.log(
        `call async ${this.constructor.name}.attributeChangedCallback(name: ${name}, oldVal: ${oldVal}, newVal: ${newVal})`
      );
    }
    if (oldVal === newVal || this.shadowRoot.childElementCount === 0) {
      if (this.debug()) {
        console.log("// with no changes");
      }
      return;
    }
    if (this.debug()) {
      console.log(`// with changes`);
    }
    await this.update();
  }

  /**
   * @returns {Promise<void>}
   */
  async connectedCallback() {
    if (this.debug()) {
      console.log(`call async ${this.constructor.name}.connectedCallback()`);
    }
    await this.update();
  }

  /**
   * @returns {Promise<void>}
   */
  async update() {
    if (this.debug()) {
      console.log(`call async ${this.constructor.name}.update()`);
    }

    const minifiedTemplate = await this.minifiedTemplate();
    if (this.#templateCache === minifiedTemplate) {
      if (this.debug()) {
        console.log("// template has not changed");
      }
      return;
    }
    if (this.debug()) {
      console.log("// template has changed");
    }

    this.render(minifiedTemplate);
  }

  /**
   * @param {string} template
   * @returns {void}
   */
  render(template) {
    if (this.debug()) {
      console.log(`call async ${this.constructor.name}.render()`);
    }

    const templateElement = document.createElement("template");
    templateElement.innerHTML = template;
    this.#templateCache = template;
    this.shadowRoot.replaceChildren();
    this.shadowRoot.appendChild(templateElement.content.cloneNode(true));
  }

  /**
   * @returns {Promise<string>}
   */
  async template() {
    return "Error: Template is missing";
  }

  /**
   * @returns {Promise<string>}
   */
  async minifiedTemplate() {
    return (await this.template())
      .replace(/\>[\r\n ]+\</g, "><")
      .replace(/(<.*?>)|\s+/g, (m, $1) => ($1 ? $1 : " "))
      .trim();
  }
}

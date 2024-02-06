export class FrontierElement extends HTMLElement {
  constructor() {
    super();

    const template = document.createElement("template");
    template.innerHTML = this.render();

    this.attachShadow({ mode: "open" }).appendChild(
      template.content.cloneNode(true)
    );
  }

  /**
   * @returns {string}
   */
  render() {
    return "Error: Template is missing";
  }
}

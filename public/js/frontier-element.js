export class FrontierElement extends HTMLElement {
  constructor() {
    super();

    const shadow = this.attachShadow({ mode: "open" });
    if (this.render().length === 0) {
      return;
    }

    const template = document.createElement("template");
    template.innerHTML = this.render();
    shadow.appendChild(template.content.cloneNode(true));
  }

  /**
   * @returns {string}
   */
  render() {
    return "";
  }
}

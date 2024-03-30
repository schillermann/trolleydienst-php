import { LitElement, css, html } from "../lit-all.min.js";

export class ViewHeader extends LitElement {
  static styles = css`
    :host {
      font-size: 12px;
    }
  `;

  constructor() {
    super();
  }

  render() {
    return html`
      <header>
        <h1>
          <slot></slot>
        </h1>
      </header>
    `;
  }
}
customElements.define("view-header", ViewHeader);

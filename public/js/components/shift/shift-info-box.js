import { LitElement, css, html } from "../../lit-all.min.js";

export class ShiftInfoBox extends LitElement {
  static styles = css`
    article {
      border: dotted;
    }
  `;

  constructor() {
    super();
  }

  render() {
    return html`
      <article>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla volutpat
        quis mauris et tincidunt. Praesent iaculis dolor maximus elit sagittis
        vehicula. Ut eget vehicula dui.
      </article>
    `;
  }
}
customElements.define("shift-info-box", ShiftInfoBox);

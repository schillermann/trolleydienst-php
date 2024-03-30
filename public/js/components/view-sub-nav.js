import { LitElement, css, html } from "../lit-all.min.js";
import { translate } from "../translate.js";

export class ViewSubNav extends LitElement {
  static styles = css`
    nav {
      margin: 20px 0px 20px 0px;
    }
  `;

  constructor() {
    super();
  }

  render() {
    return html`
      <link rel="stylesheet" href="css/fontawesome.min.css" />
      <nav>
        <view-button type="primary flex">
          <i class="fa-solid fa-plus"></i>
          ${translate("New Shift")}
        </view-button>
      </nav>
    `;
  }
}
customElements.define("view-sub-nav", ViewSubNav);

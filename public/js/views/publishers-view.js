import { LitElement, html, nothing } from "../lit-all.min.js";
import { translate } from "../translate.js";
import "../components/view-header.js";
import "../components/publisher-management.js";

export class PublishersView extends LitElement {
  static properties = {
    demo: { type: Boolean },
  };

  constructor() {
    super();
    this.demo = false;
  }

  render() {
    return html`<view-header>${translate("Publishers")}</view-header>
      <publisher-management
        demo="${this.demo || nothing}"
      ></publisher-management>`;
  }
}
customElements.define("publishers-view", PublishersView);

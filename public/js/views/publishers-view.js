import { LitElement, html } from "../lit-all.min.js";
import { translate } from "../translate.js";
import "../components/view-header.js";
import "../components/publisher-management.js";

export class PublishersView extends LitElement {
  constructor() {
    super();
  }

  render() {
    return html`<view-header>${translate("Publishers")}</view-header>
      <publisher-management></publisher-management>`;
  }
}
customElements.define("publishers-view", PublishersView);

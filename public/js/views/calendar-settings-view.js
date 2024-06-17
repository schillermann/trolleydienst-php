import { LitElement, html } from "../lit-all.min.js";
import { translate } from "../translate.js";
import "../components/calendar-settings.js";
import "../components/view-header.js";

export class CalendarSettingsView extends LitElement {
  static properties = {};

  constructor() {
    super();
  }

  render() {
    return html`<view-header>${translate("Calendar Settings")}</view-header
      ><calendar-settings></calendar-settings>`;
  }
}
customElements.define("calendar-settings-view", CalendarSettingsView);

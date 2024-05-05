import { LitElement, css, html } from "../lit-all.min.js";
import "../components/view-header.js";
import "../components/shift/shift-info-box.js";
import "../components/shift-calender.js";

export class ShiftView extends LitElement {
  constructor() {
    super();
  }

  render() {
    return html`
      <view-header>Trolley Schichten</view-header>
      <shift-info-box></shift-info-box>
      <shift-calendar calendarid="1"></shift-calendar>
    `;
  }
}
customElements.define("shift-view", ShiftView);

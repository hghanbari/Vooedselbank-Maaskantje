import * as React from "react";
import Logo from "./images/logo-sidebar.jpg";

export default function Sidebar() {
  return (
    <aside className="app-sidebar">
      <dive className="sidebar-content">
        <div className="sidebar-logo">
          <img className="logo" src={Logo} alt="Logo" />
        </div>
        <div className="sidebar-mine">
          <ul className="list-main">
            <li>
              <a href="#">
                <span class="material-symbols-outlined">computer</span>
                <span>Overzicht</span>
              </a>
            </li>
            <li>
              <a href="#">
                <span class="material-symbols-outlined">for_you</span>
                <span>Klanten</span>
              </a>
            </li>
            <li>
              <a href="#">
                <span class="material-symbols-outlined">local_shipping</span>
                <span>Leverancier</span>
              </a>
            </li>
            <li>
              <a href="#">
                <span class="material-symbols-outlined">package_2</span>
                <span>Pakketten</span>
              </a>
            </li>
            <li>
              <a href="#">
                <span class="material-symbols-outlined">article</span>
                <spam>Voorraadbeheer</spam>
              </a>
            </li>
          </ul>
        </div>
      </dive>
    </aside>
  );
}

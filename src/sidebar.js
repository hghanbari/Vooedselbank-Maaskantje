import * as React from "react";
import Logo from "./images/logo-sidebar.jpg";
import { Link } from "react-router-dom";

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
              <span class="material-symbols-outlined">computer</span>
              <a href="#">Overzicht</a>
            </li>
            <li>
              <span class="material-symbols-outlined">for_you</span>
              <a href="#">Klanten</a>
            </li>
            <li>
              <span class="material-symbols-outlined">local_shipping</span>
              <a href="#">Leverancier</a>
            </li>
            <li>
              <span class="material-symbols-outlined">package_2</span>
              <a href="#">Pakketten</a>
            </li>
            <li>
              <span class="material-symbols-outlined">article</span>
              <a href="#">Voorraadbeheer</a>
            </li>
          </ul>
        </div>
      </dive>
    </aside>
  );
}

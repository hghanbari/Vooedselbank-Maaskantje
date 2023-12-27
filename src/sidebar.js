import * as React from "react";
import Logo from "./images/logo-sidebar.jpg";
import { Link } from "react-router-dom";
export default function Sidebar() {
  return (
    <aside className="app-sidebar">
      <div className="sidebar-content">
        <div className="sidebar-logo">
          <img className="logo" src={Logo} alt="Logo" />
        </div>
        <div className="sidebar-mine">
          <ul className="list-main">
            <li>
              <Link to="/">
                <span className="material-symbols-outlined">computer</span>
                <span>Overzicht</span>
              </Link>
            </li>
            <li>
              <Link to="/customers">
                <span className="material-symbols-outlined">for_you</span>
                <span>Klanten</span>
              </Link>
            </li>
            <li>
              <Link to="/suppliers">
                <span className="material-symbols-outlined">
                  local_shipping
                </span>
                <span>Leveranciers</span>
              </Link>
            </li>
            <li>
              <Link to="/packages">
                <span className="material-symbols-outlined">package_2</span>
                <span>Pakketten</span>
              </Link>
            </li>
            <li>
              <Link to="/inventoryManagement">
                <span className="material-symbols-outlined">article</span>
                <span>Voorraadbeheer</span>
              </Link>
            </li>
            <li>
              <Link to="/UserManager">
                <span className="material-symbols-outlined">
                  <span className="material-symbols-outlined">
                    manage_accounts
                  </span>
                </span>
                <span>Userbeheer</span>
              </Link>
            </li>
          </ul>
        </div>
      </div>
    </aside>
  );
}

import * as React from "react";
import { Link } from "react-router-dom";
import axios from "axios";
import Cookies from "js-cookie";

export default function Header({
  customersStore,
  inventoryManagementStore,
  packageStore,
}) {
  const { customersList } = customersStore;
  const { inventoryManagementList } = inventoryManagementStore;
  const { packagesList } = packageStore;

  const handleRejectCookies = (e) => {
    e.preventDefault();
    axios
      .post(
        "http://localhost/backend/account/logout.php",
        // "http://localhost/Vooedselbank-Maaskantje/public/php/account/logout.php",
        {},
        {
          withCredentials: true,
        }
      )
      .then((res) => {
        Cookies.remove("PHPSESSID");
        window.location.href = "/";
      })
      .catch((err) => console.log(err));
  };
  const packageCount = Object.keys(packagesList).length;
  const inventoryManagementCount = Object.keys(inventoryManagementList).length;
  const customerCount = Object.keys(customersList).length;

  return (
    <div className="app-header">
      <div className="header-navbar">
        <Link to="/profile">
          <span className="material-symbols-outlined">account_circle</span>
        </Link>
        <Link onClick={handleRejectCookies}>
          <span className="material-symbols-outlined">logout</span>
        </Link>
      </div>
      <div className="header-card">
        <div className="card-content">
          <div>
            <h3>
              <span>Antal Pakketen</span>
              <span>{packageCount}</span>
            </h3>
            <div className="circle-icon red">
              <span className="material-symbols-outlined ">
                bar_chart_4_bars
              </span>
            </div>
          </div>
          <div>
            <p className="info">
              <span className="material-symbols-outlined ">arrow_upward</span>
              30 %
            </p>
            <p>Since last month</p>
          </div>
        </div>
        <div className="card-content">
          <div>
            <h3>
              <span>Antal Klanten</span>
              <span>{customerCount}</span>
            </h3>
            <div className="circle-icon blue">
              <span className="material-symbols-outlined ">data_usage</span>
            </div>
          </div>
          <div>
            <p className="info">
              <span className="material-symbols-outlined ">arrow_upward</span>
              25 %
            </p>
            <p>Since last month</p>
          </div>
        </div>
        <div className="card-content">
          <div>
            <h3>
              <span>Voorraad</span>
              <span>{inventoryManagementCount}</span>
            </h3>
            <div className="circle-icon yellow">
              <span className="material-symbols-outlined ">
                <span className="material-symbols-outlined">inventory</span>
              </span>
            </div>
          </div>
          <div>
            <p className="info">
              <span className="material-symbols-outlined ">arrow_upward</span>
              25 %
            </p>
            <p>Since last month</p>
          </div>
        </div>
      </div>
    </div>
  );
}

import axios from "axios";
import * as React from "react";
import { useState } from "react";
import { useEffect } from "react";
import { Link } from "react-router-dom";

export default function Header() {
const [customers,setCustomers]= useState ();

  useEffect(() => {
    axios
      .get("http://localhost/backend/json/customerJson.php")
      .then((res) => {
        setData(res.customers);
      })
      .catch((err) => console.log(err));
  }, []);


  return (
    <div className="app-header">
      <div className="header-navbar">
        <a href="#">
          <span className="material-symbols-outlined">view_agenda</span>
        </a>
        <div className="header-navbar">
          <Link to="/profile">
            <span className="material-symbols-outlined">account_circle</span>
          </Link>
          <Link to="/login">
            <span className="material-symbols-outlined">logout</span>
          </Link>
        </div>
      </div>
      <div className="header-card">
        <div className="card-content">
          <div>
            <h3>
              <span>Antal Pakketen</span>
              <span>25</span>
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
              <span>25</span>
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
              <span>780</span>
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

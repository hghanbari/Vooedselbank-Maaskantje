import * as React from "react";

export default function Header() {
  return (
    <div className="app-header">
      <div className="header-navbar">
        <a href="#">
          <span class="material-symbols-outlined">view_agenda</span>
        </a>
        <a href="#">
          <span class="material-symbols-outlined">account_circle</span>
        </a>
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
                <span class="material-symbols-outlined">inventory</span>
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

        <div className="card-content">
          <div>
            <h3>
              <span>Performance</span>
              <span>25%</span>
            </h3>
            <div className="circle-icon orange">
              <span className="material-symbols-outlined ">query_stats</span>
            </div>
          </div>
          <div>
            <p className="info">
              <span className="material-symbols-outlined ">arrow_upward</span>
              12 %
            </p>
            <p>Since last month</p>
          </div>
        </div>
      </div>
    </div>
  );
}

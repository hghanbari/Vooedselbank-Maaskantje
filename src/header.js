import * as React from "react";

export default function Header() {
  return (
    <div className="app-header">
      <div className="header-navbar">
        <a href="#">
          <span class="material-symbols-outlined">view_agenda</span>
        </a>
        <a href="#">
          <span class="material-symbols-outlined">account_circle</span>{" "}
        </a>
      </div>
      <div className="header-card">
        <div className="card-content">
          <p>Antal Pakketen</p>
          <h4>25</h4>
          <span class="material-symbols-outlined">bar_chart_4_bars</span>
        </div>
        <div className="card-content">
          <p>Antal Klanten</p>
          <h4>25</h4>
          <span class="material-symbols-outlined">data_usage</span>{" "}
        </div>
        <div className="card-content">
          <p>Voorrraad</p>
          <h4>780</h4>
          <span class="material-symbols-outlined">bar_chart_4_bars</span>
        </div>
        <div className="card-content">
          <p>Performance</p>
          <h4>25%</h4>
          <span class="material-symbols-outlined">query_stats</span>{" "}
        </div>
      </div>
    </div>
  );
}

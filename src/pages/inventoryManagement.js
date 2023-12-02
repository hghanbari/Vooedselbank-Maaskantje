import React, { useEffect } from "react";
import { useState } from "react";
import axios from "axios";

export default function InventoryManagement() {
  const [data, setData] = useState([{}]);
  useEffect(() => {
    axios
      .get("http://localhost/backend/json/supplierJson.php")
      .then((res) => {
        setData(res.data);
      })
      .catch((err) => console.log(err));
  }, []);

  return (
    <div className="body-content">
      <div className="header-content">
        <h4 className="header-title">Voorraad</h4>
        <button className="header-button">Product Toevogen</button>
      </div>
      <table className="data-table">
        <thead className="table-header">
          <tr>
            <th>Name</th>
            <th>EAN</th>
            <th>Hoeveelhied</th>
            <th>Sort</th>
            <th>Prijs</th>
          </tr>
        </thead>
        <tbody>
          {Object.values(data).map((user, index) => {
            return (
              <tr key={index}>
                <td>{user.companyName}</td>
                <td>{user.adress}</td>
                <td>{user.contactName}</td>
                <td>{user.email}</td>
                <td>{user.phone}</td>
              </tr>
            );
          })}
        </tbody>
      </table>
      <div className="pagination"></div>
    </div>
  );
}

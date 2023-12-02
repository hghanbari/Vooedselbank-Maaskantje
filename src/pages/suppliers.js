import axios from "axios";
import React from "react";
import { useState, useEffect } from "react";

export default function Suppliers() {
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
        <h4 className="header-title">Leveranciers</h4>
        <button className="header-button">Leverancier Toevogen</button>
      </div>
      <table className="data-table">
        <thead className="table-header">
          <tr>
            <th>Company</th>
            <th>Contact Person</th>
            <th>Address</th>
            <th>E-mail</th>
            <th>Phone</th>
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

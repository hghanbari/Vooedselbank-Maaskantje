import axios from "axios";
import React from "react";
import { useState, useEffect } from "react";

export default function Customers() {
  const [data, setData] = useState([{}]);
  useEffect(() => {
    axios
      .get("http://localhost/backend/json/customerJson.php")
      .then((res) => {
        setData(res.data);
      })
      .catch((err) => console.log(err));
  }, []);

  return (
    <div className="body-content">
      <div className="header-content">
        <h4 className="header-title">Klanten</h4>
        <button className="header-button">Klant Toevogen</button>
      </div>
      <table className="data-table">
        <thead className="table-header">
          <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>E-mail</th>
            <th>Phone</th>
          </tr>
        </thead>
        <tbody>
          {Object.values(data).map((user, index) => {
            return (
              <tr key={index}>
                <td>{user.firstName}</td>
                <td>{user.lastName}</td>
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

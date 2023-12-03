import axios from "axios";
import React, { useEffect } from "react";
import { useState } from "react";

export default function Packages(currentItems) {
  const [data, setData] = useState([]);

  useEffect(() => {
    axios
      .get("http://localhost/backend/json/foodPacketJson.php")
      .then((res) => {
        setData(res.data);
      })
      .catch((err) => console.log(err));
  }, [data]);

  return (
    <div className="body-content">
      <div className="header-content">
        <h4 className="header-title">Pakketten</h4>
        <button className="header-button">Pakket Toevogen</button>
      </div>
      <table className="data-table">
        <thead className="table-header">
          <tr>
            <th>Make Date</th>
            <th>Pick Up Date</th>
            <th>Customer Name</th>
          </tr>
        </thead>
        <tbody>
          {Object.values(currentItems).map((user, index) => {
            return (
              <tr key={index}>
                <td>{user.makeDate}</td>
                <td>{user.pickUpDate}</td>
                <td>{user.customer}</td>
              </tr>
            );
          })}
        </tbody>
      </table>
    </div>
  );
}

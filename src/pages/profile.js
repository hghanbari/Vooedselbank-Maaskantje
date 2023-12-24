import React from "react";
import { useState, useEffect } from "react";
import axios from "axios";

export default function Profile() {
  const [data, setData] = useState([]);

  useEffect(() => {
    axios
      .get("http://localhost/backend/json/userJson.php")
      .then((res) => {
        const myArray = Object.keys(res.data).map((key) => res.data[key]);
        console.log(res.data);
        setData(myArray);
      })
      .catch((err) => console.log(err));
  }, []);

  return (
    <div className="body-content">
      <div className="header-content">
        <h4 className="header-title">profile</h4>
        <button className="header-button">profile wijzigen</button>
      </div>
      <table className="data-table">
        <thead className="table-header">
          <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Adress</th>
            <th>Phone</th>
            <th>E-mail</th>
          </tr>
        </thead>
        <tbody>
          {data.map((user, index) => {
            return (
              <tr key={index}>
                <td>{user.firstName}</td>
                <td>{user.lastName}</td>
                <td>{user.adress}</td>
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

import React from "react";
import { useState, useEffect } from "react";
import axios from "axios";

export default function Profile({ setEditModalForm }) {
  const [data, setData] = useState([]);
  // const { profile } = profileStore;

  useEffect(() => {
    axios
      .get("http://localhost/backend/json/userJson.php")
      .then((res) => {
        const myArray = Object.keys(res.data).map((key) => res.data[key]);
        setData(myArray);
      })
      .catch((err) => console.log(err));
  }, []);

  return (
    <div className="body-content">
      <div className="header-content">
        <h4 className="header-title">profile</h4>
        <button
          className="header-button"
          onClick={() => setEditModalForm(true)}>
          profile wijzigen
        </button>
      </div>
      <table className="data-table">
        <thead className="table-header">
          <tr>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Address</th>
            <th>E-mail</th>
            <th>Phone</th>
          </tr>
        </thead>
        <tbody>
          {data.map((user, index) => {
            return (
              <tr key={index}>
                <td>{user.firstName}</td>
                <td>{user.middleName}</td>
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

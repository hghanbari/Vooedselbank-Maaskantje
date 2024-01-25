import React from "react";
import axios from "axios";
import { useState, useEffect } from "react";

export default function Home() {
  const [data, setData] = useState([]);

  useEffect(() => {
    axios
      .get("http://localhost/backend/json/customerJson.php")
      .then((res) => {
        const myArray = Object.keys(res.data).map((key) => res.data[key]);
        setData(myArray);
      })
      .catch((err) => console.log(err));
  }, []);

  return (
    <div className="body-content1">
      <div className="header-content1">
        <h4 className="header-title1">Klanten</h4>
      </div>
      <table className="data-table1">
        <thead className="table-header1">
          <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>E-mail</th>
            <th>Phone</th>
            <th>Address</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          {data.map((user, index) => {
            return (
              <tr key={index}>
                <td>{user.firstName}</td>
                <td>{user.lastName}</td>
                <td>{user.email}</td>
                <td>{user.phone}</td>
                <td>{user.address}</td>
                <td>
                  {/* Voeg hier eventueel knoppen toe voor bewerken of verwijderen */}
                </td>
              </tr>
            );
          })}
        </tbody>
      </table>

        <h4 className="header-title1">Leveranciers</h4>
        <table className="data-table1">
          <thead className="table-header1">
            <tr>
              <th>Naam</th>
              <th>E-mail</th>
              {/* Voeg hier eventueel meer kolommen toe */}
            </tr>
          </thead>
          <tbody>
            {/* Voeg hier gegevens toe voor leveranciers */}
          </tbody>
        </table>
        </div>
  );
}




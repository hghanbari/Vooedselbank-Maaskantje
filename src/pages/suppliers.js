import React from "react";
import axios from "axios";

import { useState, useEffect } from "react";

export default function Suppliers(currentItems) {
  const [data, setData] = useState([]);
  const [openModal, setOpenModal] = useState(false);

  useEffect(() => {
    axios
      .get("http://localhost/backend/json/supplierJson.php")
      .then((res) => {
        setData(res.data);
      })
      .catch((err) => console.log(err));
  }, [data]);

  return (
    <div className="body-content">
      <div className="header-content">
        <h4 className="header-title">Leveranciers</h4>
        <button className="header-button" onClick={() => setOpenModal(true)}>
          Leverancier Toevogen
        </button>
        {/* {openModal && <SupplierForm cloosModal={setOpenModal} />} */}
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
          {Object.values(currentItems).map((user, index) => {
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
    </div>
  );
}

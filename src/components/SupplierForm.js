import axios from "axios";
import * as React from "react";
import { useState, useEffect } from "react";
import { Navigate } from "react-router-dom";

export default function SupplierForm({ closeModal }) {
  const [firstname, setFirstName] = useState("");
  const [lastname, setLastName] = useState("");
  const [email, setEmail] = useState("");
  const [phone, setPhone] = useState("");
  const [familyMemberAmount, setFamilyMemberAmount] = useState("");
  const [youngestPerson, setYoungestPerson] = useState("");

  const handleSubmit = async (e) => {
    e.preventDefault();

    axios
      .post("http://localhost/backend/add/suplier.php", {
        email: "asdasd",
        name: "sadf",
      })
      .then((res) => {})
      .catch((err) => console.log(err));
  };

  return (
    <div className="modal-background">
      <div className="modal-container">
        <div className="title">
          <h4>Klant gegeven tovogen</h4>
          <button
            className="modal-close-button"
            onClick={() => {
              closeModal(false);
            }}>
            X
          </button>
        </div>
        <div className="form">
          <form className="form" onSubmit={handleSubmit}>
            <div className="form-item">
              <label htmlFor="name">Name:</label>
              <input type="text" name="name" />
            </div>
            <div className="form-item">
              <label htmlFor="email">Email:</label>
              <input
                type="email"
                name="email"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
              />
            </div>
            <div className="form-item">
              <label htmlFor="password">Password:</label>
              <input type="password" name="password" />
            </div>
            <div className="form-item">
              <label></label>
              <button onClick={}>Tovogen</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
}

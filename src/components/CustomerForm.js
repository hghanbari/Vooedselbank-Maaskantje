import axios from "axios";
import * as React from "react";
import { useState, useEffect } from "react";

export default function CustomerForm({ closeModal }) {
  const [firstName, setFirstName] = useState("");
  const [lastName, setLastName] = useState("");
  const [email, setEmail] = useState("");
  const [phone, setPhone] = useState("");
  const [amount, setAmount] = useState("");
  const [age, setAge] = useState("");

  const handleSubmit = async (e) => {
    e.preventDefault();

    axios
      .post("http://localhost/backend/add/customer.php", {
        email: "asdasd",
        firstName: "sadf",
        lastName: "sadf",
        phone: "sadf",
        amount: "sadf",
        age: "sadf",
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
        <form className="form" onSubmit={handleSubmit}>
          <div className="form-item">
            <label htmlFor="firstName">First Name:</label>
            <input
              type="text"
              name="name"
              value={firstName}
              onChange={(e) => setFirstName(e.target.value)}
            />
          </div>
          <div className="form-item">
            <label htmlFor="lastName">Last Name:</label>
            <input
              type="text"
              name="name"
              value={lastName}
              onChange={(e) => setLastName(e.target.value)}
            />
          </div>
          <div className="form-item">
            <label htmlFor="email">E-mail:</label>
            <input
              type="email"
              name="email"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
            />
          </div>
          <div className="form-item">
            <label htmlFor="number">Age:</label>
            <input
              type="number"
              name="number"
              value={age}
              onChange={(e) => setAge(e.target.value)}
            />
          </div>
          <div className="form-item">
            <label htmlFor="number">Phone:</label>
            <input
              type="number"
              name="number"
              value={phone}
              onChange={(e) => setPhone(e.target.value)}
            />
          </div>
          <div className="form-item">
            <label htmlFor="number">Phone:</label>
            <input
              type="number"
              name="number"
              value={amount}
              onChange={(e) => setAmount(e.target.value)}
            />
          </div>

          <div className="form-item">
            <label></label>
            <button>Register</button>
          </div>
        </form>
      </div>
    </div>
  );
}

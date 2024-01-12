import axios from "axios";
import React, { useState, useEffect } from "react";

export default function ProfileEdit({ id, closeModalEdit, profileStore }) {
  const { fetchProfile } = profileStore;
  const [firstName, setFirstName] = useState("");
  const [middleName, setMiddleName] = useState("");
  const [lastName, setLastName] = useState("");
  const [email, setEmail] = useState("");
  const [phone, setPhone] = useState("");
  const [address, setAddress] = useState("");
  const [password, setPassword] = useState("");

  useEffect(() => {
    axios
      .get("http://localhost/backend/json/userJson.php?id=" + id, {
        withCredentials: true,
      })
      .then((res) => {
        const data = res.data[0];
        setFirstName(data.firstName);
        setMiddleName(data.middleName);
        setLastName(data.lastName);
        setEmail(data.email);
        setPhone(data.phone);
        setAddress(data.address);
      })
      .catch((err) => console.log(err));
  }, [id]);

  const handleSubmit = async (e) => {
    e.preventDefault();
    axios
      .post(
        "http://localhost/backend/actions/edit/userJson.php",
        {
          firstName: firstName,
          middleName: middleName,
          lastName: lastName,
          email: email,
          phone: phone,
          password: password,
          address: address,
        },
        {
          withCredentials: true,
        }
      )
      .then((res) => {
        if (res.data.success) {
          alert(res.data.message);
          closeModalEdit(false);
          fetchProfile();
        }
      })
      .catch((err) => console.log(err));
  };

  return (
    <div className="modal-background">
      <div className="modal-container">
        <div className="title">
          <h4>Profile Wijzegen</h4>
          <button
            className="modal-close-button"
            onClick={() => {
              closeModalEdit(false);
            }}>
            X
          </button>
        </div>
        <div className="underline-title"></div>
        <form method="post" className="form" onSubmit={handleSubmit}>
          <label htmlFor="firstName">First Name:</label>
          <input
            type="text"
            name="name"
            value={firstName}
            onChange={(e) => setFirstName(e.target.value)}
            className="form-content"
            required
          />
          <div className="form-border"></div>
          <label htmlFor="middleName">Middle Name:</label>
          <input
            type="text"
            name="name"
            value={middleName}
            onChange={(e) => setMiddleName(e.target.value)}
            className="form-content"
          />
          <div className="form-border"></div>
          <label htmlFor="lastName">Last Name:</label>
          <input
            type="text"
            name="name"
            value={lastName}
            onChange={(e) => setLastName(e.target.value)}
            className="form-content"
            required
          />
          <div className="form-border"></div>
          <label htmlFor="email">E-mail:</label>
          <input
            type="email"
            name="email"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            className="form-content"
            required
          />
          <div className="form-border"></div>
          <label htmlFor="number">Address:</label>
          <input
            type="date"
            name="text"
            value={address}
            onChange={(e) => setAddress(e.target.value)}
            className="form-content"
            required
          />
          <div className="form-border"></div>
          <label htmlFor="number">Phone:</label>
          <input
            type="number"
            name="number"
            value={phone}
            onChange={(e) => setPhone(e.target.value)}
            className="form-content"
            required
          />
          <div className="form-border"></div>
          <label htmlFor="number">Password:</label>
          <input
            type="password"
            name="password"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            className="form-content"
            required
          />
          <div className="form-border"></div>
          <input id="submit-btn" type="submit" name="submit" value="Opslaan" />
        </form>
      </div>
    </div>
  );
}

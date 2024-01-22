import axios from "axios";
import React, { useEffect, useState } from "react";

export default function Profile() {
  const [firstName, setFirstName] = useState("");
  const [middleName, setMiddleName] = useState("");
  const [lastName, setLastName] = useState("");
  const [email, setEmail] = useState("");
  const [phone, setPhone] = useState("");
  const [address, setAddress] = useState("");
  const [password, setPassword] = useState("");
  const [nPassword, setNPassword] = useState("");

  useEffect(() => {
    axios
      .get("http://localhost/backend/account/profile.php", {
      // .get("http://localhost/Vooedselbank-Maaskantje/public/php/account/profile.php", {
        withCredentials: true,
      })
      .then((res) => {
        setFirstName(res.data.firstName);
        setMiddleName(res.data.middleName);
        setLastName(res.data.lastName);
        setEmail(res.data.email);
        setPhone(res.data.phone);
        setAddress(res.data.address);
      })
      .catch((err) => console.log(err));
  }, []);

  const handleSubmit = async (e) => {
    e.preventDefault();
    axios
      .post(
        "http://localhost/backend/actions/edit/profile.php",
        // "http://localhost/Vooedselbank-Maaskantje/public/php/actions/edit/profile.php",
        {
          firstName: firstName,
          middleName: middleName,
          lastName: lastName,
          email: email,
          phone: phone,
          password: password,
          nPassword: nPassword,
          address: address,
        },
        {
          withCredentials: true,
        }
      )
      .then((res) => {
        if (res.data.success) {
          alert(res.data.message);
        }
      })
      .catch((err) => console.log(err));
  };
  return (
    <div className="body-content">
      <form method="post" className="profile" onSubmit={handleSubmit}>
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
          type="text"
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
        <label htmlFor="number">New password:</label>
        <input
          type="password"
          name="nPassword"
          value={nPassword}
          onChange={(e) => setNPassword(e.target.value)}
          className="form-content"
        />
        <div className="form-border"></div>
        <input id="submit-btn" type="submit" name="submit" value="Opslaan" />
      </form>
    </div>
  );
}

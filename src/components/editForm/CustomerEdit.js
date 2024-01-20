import axios from "axios";
import React, { useEffect, useState } from "react";

export default function CustomerEdit({ id, closeModal, customersStore }) {
  const { fetchCustomers } = customersStore;
  const [firstName, setFirstName] = useState("");
  const [middleName, setMiddleName] = useState("");
  const [lastName, setLastName] = useState("");
  const [address, setAddress] = useState("");
  const [email, setEmail] = useState("");
  const [phone, setPhone] = useState("");
  const [famAmount, setFamAmount] = useState("");
  const [age, setAge] = useState("");
  const [specifics, setSpecifics] = useState("");

  useEffect(() => {
    axios
      .get("http://localhost/backend/json/customerJson.php?id=" + id, {
      // .get("http://localhost/Vooedselbank-Maaskantje/public/php/json/customerJson.php?id=" + id, {
        withCredentials: true,
      })
      .then((res) => {
        const data = res.data[0];
        setFirstName(data.firstName);
        setMiddleName(data.middleName);
        setLastName(data.lastName);
        setEmail(data.email);
        setFamAmount(data.familyMemberAmount);
        setPhone(data.phone);
        setAddress(data.address);
        setAge(data.youngestPerson);
        setSpecifics(data.specId);
      })
      .catch((err) => console.log(err));
  }, [id]);

  const handleSubmit = async (e) => {
    e.preventDefault();
    axios
      .post(
        "http://localhost/backend/actions/edit/customer.php",
        // "http://localhost/Vooedselbank-Maaskantje/public/php/actions/edit/customer.php",
        {
          id: id,
          firstName: firstName,
          middleName: middleName,
          lastName: lastName,
          email: email,
          phone: phone,
          address: address,
          amount: famAmount,
          youngest: age,
          specifics: specifics,
        },
        {
          withCredentials: true,
        }
      )
      .then((res) => {
        if (res.data.success) {
          alert(res.data.message);
          closeModal();
          fetchCustomers();
        }
      })
      .catch((err) => console.log(err));
  };

  return (
    <div className="modal-background">
      <div className="modal-container">
        <div className="title">
          <h4>Klant gegeven wijzegen</h4>
          <button
            className="modal-close-button"
            onClick={() => {
              closeModal();
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

          <label htmlFor="number">Youngest family member:</label>
          <input
            type="date"
            name="number"
            value={age}
            onChange={(e) => setAge(e.target.value)}
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
          <label htmlFor="text">Address:</label>
          <input
            type="text"
            name="text"
            value={address}
            onChange={(e) => setAddress(e.target.value)}
            className="form-content"
            required
          />
          <div className="form-border"></div>
          <label htmlFor="number">Family members:</label>
          <input
            type="number"
            name="number"
            value={famAmount}
            onChange={(e) => setFamAmount(e.target.value)}
            className="form-content"
            required
          />
          <div className="form-border"></div>

          <label htmlFor="number">allergieen</label>
          <select
            name="specifics"
            value={specifics}
            onChange={(e) => setSpecifics(e.target.value)}
            className="form-content">
            {/* {data.map((specific) => {
              return (
                <option value={specific.specificId}>{specific.desc}</option>
              );
            })} */}
          </select>
          <div className="form-border"></div>

          <input id="submit-btn" type="submit" name="submit" value="Opslaan" />
        </form>
      </div>
    </div>
  );
}

import axios from "axios";
import React, { useState, useEffect } from "react";

export default function SupplierEdit({ id, closeModal, suppliersStore }) {
  const { fetchSuppliers } = suppliersStore;
  const [companyName, setCompanyName] = useState("");
  const [address, setAddress] = useState("");
  const [phone, setPhone] = useState("");
  const [contactPerson, setContactPerson] = useState("");
  const [email, setEmail] = useState("");

  useEffect(() => {
    axios
      // .get("http://localhost/backend/json/customerJson.php?id=" + id, {
      .get("http://localhost/Vooedselbank-Maaskantje/public/php/json/customerJson.php?id=" + id, {
        withCredentials: true,
      })
      .then((res) => {
        setCompanyName(res.data.companyName);
        setAddress(res.data.address);
        setEmail(res.data.email);
        setContactPerson(res.data.contactPerson);
        setPhone(res.data.phone);
      })
      .catch((err) => console.log(err));
  });

  const handleSubmit = async (e) => {
    e.preventDefault();
    axios
      // .post("http://localhost/backend/actions/add/supplier.php", {
      .post("http://localhost/Vooedselbank-Maaskantje/public/php/actions/add/supplier.php", {
        id: id,
        companyName: companyName,
        address: address,
        phone: phone,
        contactPerson: contactPerson,
        email: email,
      })
      .then((res) => {
        if (res.data.success) {
          alert(res.data.message);
          closeModal();
          fetchSuppliers();
        }
      })
      .catch((err) => console.log(err));
  };

  return (
    <div className="modal-background">
      <div className="modal-container">
        <div className="title">
          <h4>Leverancier gegeven wijzegen</h4>
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
          <label htmlFor="companyName">Bedrijfsnaam:</label>
          <input
            type="text"
            name="companyName"
            value={companyName}
            onChange={(e) => setCompanyName(e.target.value)}
            className="form-content"
            required
          />
          <div className="form-border"></div>

          <label htmlFor="address">Adres:</label>
          <input
            type="text"
            name="address"
            value={address}
            onChange={(e) => setAddress(e.target.value)}
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

          <label htmlFor="contactPerson">Contact persoon:</label>
          <input
            type="text"
            name="contactPerson"
            value={contactPerson}
            onChange={(e) => setContactPerson(e.target.value)}
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
          <input id="submit-btn" type="submit" name="submit" value="Opslaan" />
        </form>
      </div>
    </div>
  );
}

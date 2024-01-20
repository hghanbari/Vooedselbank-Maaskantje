import axios from "axios";
import * as React from "react";
import { useState, useEffect } from "react";

export default function PackageEdit({ id, closeModal, packerStore }) {
  const { fetchPackages } = packerStore;
  const [customer, setCustomer] = useState("");
  const [product, setProduct] = useState("");
  const [customerData, setCustomerData] = useState([]);
  const [productData, setProductData] = useState([]);

  useEffect(() => {
    axios
      .get("http://localhost/backend/json/customerJson.php")
      // .get("http://localhost/Vooedselbank-Maaskantje/public/php/json/customerJson.php")
      .then((res) => {
        const customer = Object.keys(res.data).map((key) => res.data[key]);
        setCustomerData(customer);
      })
      .catch((err) => console.log(err));
  }, []);

  useEffect(() => {
    axios
      .get("http://localhost/backend/json/foodPacketJson.php?=" + id)
      // .get("http://localhost/Vooedselbank-Maaskantje/public/php/json/foodPacketJson.php?=" + id)
      .then((res) => {
        const productArr = Object.keys(res.data).map((key) => res.data[key]);
        setProductData(productArr);
      })
      .catch((err) => console.log(err));
  }, [id]);

  const handleSubmit = async (e) => {
    e.preventDefault();
    axios
      .post(
        "http://localhost/backend/actions/add/foodPacket.php",
        // "http://localhost/Vooedselbank-Maaskantje/public/php/actions/add/foodPacket.php",
        {
          Customer: customer,
          product: product,
        },
        {
          withCredentials: true,
        }
      )
      .then((res) => {
        alert(res.data.message);
        closeModal();
        fetchPackages();
      })
      .catch((err) => console.log(err));
  };

  return (
    <div className="modal-background">
      <div className="modal-container">
        <div className="title">
          <h4>Pakket toevoegen wijzegen</h4>
          <button
            className="modal-close-button"
            onClick={() => {
              closeModal(false);
            }}>
            X
          </button>
        </div>
        <div className="underline-title"></div>
        <form method="post" className="form" onSubmit={handleSubmit}>
          <label htmlFor="customer">Klant:</label>
          <select
            name="customer"
            value={customer}
            onChange={(e) => setCustomer(e.target.value)}
            className="form-content">
            {customerData.map((customer) => {
              return (
                <option key={customer.custId} value={customer.custId}>
                  {customer.firstName} {customer.lastName}
                </option>
              );
            })}
          </select>
          <div className="form-border"></div>

          <label htmlFor="lastName">product:</label>
          <select
            name="product"
            value={product}
            onChange={(e) => setProduct(e.target.value)}
            className="form-content">
            {productData.map((product) => {
              return (
                <option key={product.packetId} value={product.ean}>
                  {product.name}
                </option>
              );
            })}
          </select>
          <div className="form-border"></div>
          <input
            id="submit-btn"
            type="submit"
            name="submit"
            value="Toevoegen"
          />
        </form>
      </div>
    </div>
  );
}

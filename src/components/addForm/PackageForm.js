import axios from "axios";
import * as React from "react";
import { useState, useEffect } from "react";

export default function PackageForm({ closeModalForm, packageStore }) {
  const { fetchPackages } = packageStore;
  const [customer, setCustomer] = useState("");
  const [product, setProduct] = useState("");
  const [amount, setAmount] = useState(0);

  const [customerData, setCustomerData] = useState([]);
  const [productData, setProductData] = useState([]);

  useEffect(() => {
    axios
      // .get("http://localhost/backend/json/customerJson.php")
      .get("http://localhost/Vooedselbank-Maaskantje/public/php/json/customerJson.php")
      .then((res) => {
        const customer = Object.keys(res.data).map((key) => res.data[key]);
        setCustomerData(customer);
        // console.log(res.data);
      })
      .catch((err) => console.log(err));
  }, []);

  useEffect(() => {
    axios
      // .get("http://localhost/backend/json/foodPacketJson.php")
      .get("http://localhost/Vooedselbank-Maaskantje/public/php/json/productJson.php")
      .then((res) => {
        const productArr = Object.keys(res.data).map((key) => res.data[key]);
        setProductData(productArr);
        // console.log("Products", productArr);
      })
      .catch((err) => console.log(err));
  }, []);

  const handleSubmit = async (e) => {
    e.preventDefault();
    axios
      .post(
        // "http://localhost/backend/actions/add/foodPacket.php",
        "http://localhost/Vooedselbank-Maaskantje/public/php/actions/add/foodPacket.php",
        {
          customer: customer,
          product: product,
          amount: amount,
        },
        {
          withCredentials: true,
        }
      )
      .then((res) => {
        if (res.data.success) {
          alert(res.data.message);
          closeModalForm(false);
          fetchPackages();
        }
      })
      .catch((err) => console.log(err));
  };

  return (
    <div className="modal-background">
      <div className="modal-container">
        <div className="title">
          <h4>Pakket toevoegen</h4>
          <button
            className="modal-close-button"
            onClick={() => {
              closeModalForm(false);
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
                <option key={customer.customerId} value={customer.customerId}>
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
              // console.log(product);
              return (
                <option key={product.EAN} value={product.EAN + "&" + product.stockId}>
                  {product.name}
                </option>
              );
            })}
          </select>
          <div className="form-border"></div>

          <label htmlFor="amount">hoeveel:</label>
          <input
            type="number"
            name="amount"
            value={amount}
            onChange={(e) => setAmount(e.target.value)}
            className="form-content"
          />
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

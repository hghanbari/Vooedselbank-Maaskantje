import axios from "axios";
import * as React from "react";
import { useState, useEffect } from "react";

export default function PackageForm({ closeModalForm, packageStore }) {
  const { fetchPackages, customerData, productData } = packageStore;

  const [customer, setCustomer] = useState("");
  const [product, setProduct] = useState("");
  const [amount, setAmount] = useState("");


  const [order, setOrder] = useState([]);

  let nextId = 0;

  const handleSubmit = async (e) => {
    e.preventDefault();
    console.log(order);
    axios
      .post(
        "http://localhost/backend/actions/add/foodPacket.php",
        // "http://localhost/Vooedselbank-Maaskantje/public/php/actions/add/foodPacket.php",
        {
          customer: customer,
          order: order,
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
            className="form-content"
            required
            >
            <option value={""}>Select</option>
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
            className="form-content"
            required
            >
            <option value={""}>Select</option>
            {productData.map((product) => {
              // console.log(product);
              return (
                <option
                  key={product.EAN}
                  value={product.EAN + "&" + product.stockId + "&" + product.name}>
                  {product.name}
                </option>
              );
            })}
          </select>
          <div className="form-border"></div>

          <label htmlFor="amount">Hoeveel:</label>
          <input
            type="number"
            name="amount"
            value={amount}
            onChange={(e) => setAmount(e.target.value)}
            className="form-content"
          />
          <div className="form-border"></div>
          <button
            onClick={(e) => {
              e.preventDefault();
              setOrder([
                ...order,
                { id: nextId++, amount: amount, product: product },
              ]);
              console.log(order);
            }}>
            Add
          </button>
          <ul>
            {order.map((order) => (
              <li key={order.id}>
                {order.product}X{order.amount}
                {/* <button
                  onClick={() => {
                    setOrder(
                      Object.values(order).filter((id) => id.id !== order.id)
                    );
                  }}>
                  Delete
                </button> */}
              </li>
            ))}
          </ul>
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

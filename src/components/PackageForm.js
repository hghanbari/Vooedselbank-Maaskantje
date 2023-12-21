import axios from "axios";
import * as React from "react";
import { useState, useEffect } from "react";

export default function PackageForm({ closeModal }) {
  const [klant, setKlant] = useState("");
  const [product, setProduct] = useState("");

  const [customerData, setCustomerData] = useState([]);
  const [productData, setProductData] = useState([]);


  useEffect(() => {
    axios
      .get("http://localhost/code/Vooedselbank-Maaskantje/public/php/json/customerJson.php")
      .then((res) => {
        const customer = Object.keys(res.data).map(key => res.data[key]);
        setCustomerData(customer);
        console.log(res.data);
      })
      .catch((err) => console.log(err));
  }, []);

  useEffect(() => {
    axios
      .get("http://localhost/code/Vooedselbank-Maaskantje/public/php/json/productJson.php")
      .then((res) => {
        const productArr = Object.keys(res.data).map(key => res.data[key]);
        setProductData(productArr);
        console.log(res.data);
      })
      .catch((err) => console.log(err));
  }, []);

  const handleSubmit = async (e) => {
    e.preventDefault();
    axios
      .post("http://localhost/code/Vooedselbank-Maaskantje/public/php/actions/add/foodPacket.php", {
        klant: klant,
        product: product
      },
      {
        withCredentials: true,
      })
      .then((res) => {
        closeModal(false);
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
              closeModal(false);
            }}>
            X
          </button>
        </div>
        <div className="underline-title"></div>
        <form method="post" className="form" onSubmit={handleSubmit}>
          <label htmlFor="klant">Klant:</label>
          <select
            name="klant"
            value={klant}
            onChange={(e) => setKlant(e.target.value)}
            className="form-content"
          >
          {customerData.map((klant) => {
            return (
              <option value={klant.custId}>{klant.firstName} {klant.lastName}</option>
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
          >
          {productData.map((product) => {
            return (
              <option value={product.ean}>{product.name}</option>
            );
          })}
          </select>
          <div className="form-border"></div>
          <input id="submit-btn" type="submit" name="submit" value="Toevoegen" />
        </form>
      </div>
    </div>
  );
}

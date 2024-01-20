import axios from "axios";
import React, { useState, useEffect } from "react";

export default function InventoryManagementEdit({
  id,
  closeModal,
  inventoryManagementStore,
}) {
  const { fetchInventoryManagement } = inventoryManagementStore;
  const [delivery, setDelivery] = useState("");
  const [amount, setAmount] = useState(0);
  const [bestByDate, setBestByDate] = useState("");
  const [ean, setEan] = useState("");

  const [productData, setProductData] = useState([]);
  const [deliveryData, setDeliveryData] = useState([]);

  useEffect(() => {
    axios
      .get("http://localhost/backend/json/stockJson.php?id=" + id, {
      // .get("http://localhost/Vooedselbank-Maaskantje/public/php/json/stockJson.php?id=" + id, {
        withCredentials: true,
      })
      .then((res) => {
        setDelivery(res.data.delivery);
        setAmount(res.data.amount);
        setBestByDate(res.data.bestByDate);
        setEan(res.data.ean);
      })
      .catch((err) => console.log(err));
  }, [id]);

  useEffect(() => {
    axios
      .get("http://localhost/backend/json/productDeliveryJson.php")
      // .get("http://localhost/Vooedselbank-Maaskantje/public/php/json/productDeliveryJson.php")
      .then((res) => {
        const data = Object.keys(res.data).map((key) => res.data[key]);
        setProductData(data[0]);
        setDeliveryData(data[1]);
      })
      .catch((err) => console.log(err));
  }, []);

  const handleSubmit = async (e) => {
    e.preventDefault();
    axios
      .post(
        "http://localhost/backend/actions/add/stock.php",
        // "http://localhost/Vooedselbank-Maaskantje/public/php/actions/add/stock.php",
        {
          delivery: delivery,
          amount: amount,
          bestByDate: bestByDate,
          ean: ean,
        },
        {
          withCredentials: true,
        }
      )
      .then((res) => {
        alert(res.data.message);
        closeModal();
        fetchInventoryManagement();
      })
      .catch((err) => console.log(err));
  };

  return (
    <div className="modal-background">
      <div className="modal-container">
        <div className="title">
          <h4>Voorraad gegeven toevoegen</h4>
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
          <label htmlFor="product">Product: </label>
          <select
            name="product"
            value={ean}
            onChange={(e) => setEan(e.target.value)}
            className="form-content"
            required>
            {productData.map((product, index) => {
              return (
                <option key={index} value={product.EAN}>
                  {product.name}
                </option>
              );
            })}
          </select>
          <div className="form-border"></div>

          <label htmlFor="delivery">Bestelling:</label>
          <select
            name="delivery"
            value={delivery}
            onChange={(e) => setDelivery(e.target.value)}
            className="form-content"
            required>
            {deliveryData.map((delivery, index) => {
              return (
                <option key={index} value={delivery.deliveryId}>
                  {delivery.companyName} {delivery.deliveryDate}
                </option>
              );
            })}
          </select>
          <div className="form-border"></div>
          <label htmlFor="amount">hoeveelheid:</label>
          <input
            type="amount"
            name="amount"
            value={amount}
            onChange={(e) => setAmount(e.target.value)}
            className="form-content"
            required
          />
          <div className="form-border"></div>

          <label htmlFor="bestByDate">Goed tot:</label>
          <input
            type="date"
            name="bestByDate"
            value={bestByDate}
            onChange={(e) => setBestByDate(e.target.value)}
            className="form-content"
            required
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

import * as React from "react";
import axios from "axios";
import { useState } from "react";

export default function UserManagerEdit({ closeModalEdit, userStore }) {
  const { fetchUsers } = userStore;
  const [firstName, setFirstName] = useState("");
  const [middleName, setMiddleName] = useState("");
  const [lastName, setLastName] = useState("");
  const [email, setEmail] = useState("");
  const [phone, setPhone] = useState("");
  const [famAmount, setFamAmount] = useState("");
  const [age, setAge] = useState("");
  const [specifics, setSpecifics] = useState("");

  // useEffect(() => {
  //   axios
  //     .get("http://localhost/backend/json/.php")
  //     .then((res) => {
  //       const specificsArr = Object.keys(res.data).map((key) => res.data[key]);
  //       setData(specificsArr);
  //     })
  //     .catch((err) => console.log(err));
  // }, []);

  const handleSubmit = async (e) => {
    e.preventDefault();
    axios
      .get(
        "http://localhost/backend/actions/edit/customer.php",
        {
          email: email,
          firstName: firstName,
          middleName: middleName,
          lastName: lastName,
          phone: phone,
          amount: famAmount,
          age: age,
          specifics: specifics,
        },
        {
          withCredentials: true,
        }
      )
      .then((res) => {
        if (res.data.success) {
          alert(res.data.message);
          closeModalEdit(false);
          fetchUsers();
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

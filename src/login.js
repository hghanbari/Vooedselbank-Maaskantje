import * as React from "react";
import "./styles/login.css";
import axios from "axios";
import { useState } from "react";

export default function Login() {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");

  const handleSubmit = async (e) => {
    e.preventDefault();
    axios
      .post(
        "http://localhost/backend/account/login.php",
        {
          email: email,
          password: password,
        },

        {
          withCredentials: true,
        }
      )
      .then((res) => {})
      .catch((err) => console.log(err));
  };

  return (
    <>
      <div className="backdrop">
        <span></span>
        <span></span>
      </div>
      <header className="login-header">
        <h1 className="header-title">Welkom!</h1>
        <p className="header-Paragraph">
          Log in met uw gebruikersnaam en wachtwoord.
        </p>
      </header>
      <div className="card">
        <div id="card-content">
          <div id="card-title">
            <h2>LOGIN</h2>
            <div className="underline-title"></div>
          </div>
          <form method="post" className="form" onClick={handleSubmit}>
            <label for="user-email">&nbsp;Email</label>
            <input
              id="user-email"
              className="form-content"
              type="email"
              name="email"
              autocomplete="on"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              required
            />
            <div className="form-border"></div>
            <label for="user-password">&nbsp;Password</label>
            <input
              id="user-password"
              className="form-content"
              type="password"
              name="password"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              required
            />
            <div className="form-border"></div>
            <input id="submit-btn" type="submit" name="submit" value="LOGIN" />
          </form>
        </div>
      </div>
    </>
  );
}

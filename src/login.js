import * as React from "react";
import "./styles/login.css";
import axios from "axios";
import { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import { useCookies } from "react-cookie";

export default function Login() {
  const [updateCookies] = useCookies(["PHPSESSID"]);

  const navigate = useNavigate();
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");
  const [msg, setMas] = useState("");

  useEffect(() => {
    setTimeout(function () {
      setMas("");
    }, 3000);
  }, [msg]);

  const handleSubmit = async (e, type) => {
    e.preventDefault();
    switch (type) {
      case "email":
        setError("");
        setEmail(e.target.value);
        if (e.target.value === "") {
          setError("Username has left blank");
        }
        break;
      case "password":
        setError("");
        setPassword(e.target.value);
        if (e.target.value === "") {
          setError("Password has left blank");
        }
        break;
      default:
    }
    if (email !== "" && password !== "") {
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
        .then((res) => {
          // updateCookies();
          window.location.href = "/home";
          // navigate("/home");
        })
        .catch((err) => console.log(err));
    }
    return false;
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
            <p>
              {error !== "" ? (
                <span className="error">{error}</span>
              ) : (
                <span className="success">{msg}</span>
              )}
            </p>
            <div className="underline-title"></div>
          </div>
          <form method="post" className="form" onClick={handleSubmit}>
            <label htmlFor="user-email">&nbsp;Email</label>
            <input
              id="user-email"
              className="form-content"
              type="email"
              name="email"
              autoComplete="on"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              required
            />
            <div className="form-border"></div>
            <label htmlFor="user-password">&nbsp;Password</label>
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

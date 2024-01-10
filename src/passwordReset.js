import "./styles/login.css";
import axios from "axios";
import { useState, useEffect } from "react";
import { Link } from "react-router-dom";

export default function PasswordReset() {
  const [email, setEmail] = useState("");
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
      default:
    }
    if (email !== "") {
      axios
        .post(
          "http://localhost/backend/account/.php",
          {
            email: email,
          },

          {
            withCredentials: true,
          }
        )
        .then((res) => {
          if (res.data.success) {
            window.location.href = "/login";
          } else {
            setError(res.data.message);
          }
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
        <h1 className="header-title">Welkoom!</h1>
        <p className="header-Paragraph">
          Bent u uw wachtwoord vergeten, vul dan onderstaand formulier in.
        </p>
      </header>
      <div className="card">
        <div id="card-content">
          <div id="card-title">
            <h2>Password Reset</h2>
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
            <Link to="/">
              <legend className="forgot-pass">Login</legend>
            </Link>
            <input id="submit-btn" type="submit" name="submit" value="Send" />
          </form>
        </div>
      </div>
    </>
  );
}

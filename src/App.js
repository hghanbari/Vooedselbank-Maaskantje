import Header from "./header";
import Sidebar from "./sidebar";
import Footer from "./footer";
import Login from "./login";
import "./styles/main.css";

function App() {
  fetch("php/account/login.php", {
    method: "POST",
    body: JSON.stringify({
      email: "",
      password: "",
    }),
  });
  return (
    <main>
      <link
        rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
      />
      <Login />
    </main>
  );
}

export default App;

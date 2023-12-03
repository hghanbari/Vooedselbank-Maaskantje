import Header from "./header";
import Sidebar from "./sidebar";
import Footer from "./footer";
import Home from "./pages/home";
import Customers from "./pages/customers";
import Suppliers from "./pages/suppliers";
import Packages from "./pages/packages";
import Profile from "./pages/profile";
import InventoryManagement from "./pages/inventoryManagement";
import { BrowserRouter, Route, Routes } from "react-router-dom";
import { useState } from "react";
import CustomerForm from "./components/CustomerForm";
import "./styles/main.css";
import Login from "./login";
import Cookies from "js-cookie";

function App() {
  const [customerModal, setCustomerModal] = useState(false);
  const sesId = Cookies.get("PHPSESSID");

  return (
    <BrowserRouter>
      {sesId ? (
        <Login />
      ) : (
        <main className="app">
          <link
            rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
          />
          <Sidebar />
          <div className="app-body">
            <Header />
            <Routes>
              <Route path="/" element={<Home />} />
              <Route path="/profile" element={<Profile />} />
              <Route
                path="/customers"
                element={<Customers setModal={setCustomerModal} />}
              />
              <Route path="/suppliers" element={<Suppliers />} />
              <Route path="/packages" element={<Packages />} />
              <Route
                path="/inventoryManagement"
                element={<InventoryManagement />}
              />
            </Routes>
            <Footer />
          </div>{" "}
        </main>
      )}
      {customerModal && <CustomerForm closeModal={setCustomerModal} />}
    </BrowserRouter>
  );
}

export default App;

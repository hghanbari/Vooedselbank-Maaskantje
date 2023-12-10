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
import PackageForm from "./components/PackageForm";
import SupplierForm from "./components/SupplierForm";
import InventoryManagementForm from "./components/InventoryManagementForm";
import "./styles/main.css";
import Login from "./login";
import Cookies from "js-cookie";

function App() {
  const [customerModal, setCustomerModal] = useState(false);
  const [packageModal, setPackageModal] = useState(false);
  const [supplierModal, setSupplierModal] = useState(false);
  const [inventoryManagementModal, setInventoryManagementModal] =
    useState(false);
  const session = Cookies.get("PHPSESSID");

  return (
    <BrowserRouter>
      {session ? (
        <main className="app">
          <link
            rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
          />
          <Sidebar />
          <div className="app-body">
            <Header />
            <Routes>
              <Route path="/home" element={<Home />} />
              <Route path="/profile" element={<Profile />} />
              <Route
                path="/customers"
                element={<Customers setModal={setCustomerModal} />}
              />
              <Route
                path="/suppliers"
                element={<Suppliers setModal={setSupplierModal} />}
              />
              <Route
                path="/packages"
                element={<Packages setModal={setPackageModal} />}
              />
              <Route
                path="/inventoryManagement"
                element={
                  <InventoryManagement setModal={setInventoryManagementModal} />
                }
              />
            </Routes>
            <Footer />
          </div>
        </main>
      ) : (
        <Routes>
          <Route path="/" element={<Login />} />
        </Routes>
      )}
      {customerModal && <CustomerForm closeModal={setCustomerModal} />}
      {packageModal && <PackageForm closeModal={setPackageModal} />}
      {supplierModal && <SupplierForm closeModal={setSupplierModal} />}
      {inventoryManagementModal && (
        <InventoryManagementForm closeModal={setInventoryManagementModal} />
      )}
    </BrowserRouter>
  );
}

export default App;

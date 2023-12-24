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
import CustomerForm from "./components/addForm/CustomerForm";
import PackageForm from "./components/addForm/PackageForm";
import SupplierForm from "./components/addForm/SupplierForm";
import InventoryManagementForm from "./components/addForm/InventoryManagementForm";
import CustomerEdit from "./components/editForm/CustomerEdit";
import PackageEdit from "./components/editForm/PackageEdit";
import SupplierEdit from "./components/editForm/SupplierEdit";
import InventoryManagementEdit from "./components/editForm/InventoryManagementEdit";
import "./styles/main.css";
import Login from "./login";
import Cookies from "js-cookie";
import useCustomers from "./states/useCustomers";
import useSupplier from "./states/useSupplier";

function App() {
  const customerStore = useCustomers();
  const suppliersStore = useSupplier();
  const [customerModalForm, setCustomerModalForm] = useState(false);
  const [packageModalForm, setPackageModalForm] = useState(false);
  const [supplierModalForm, setSupplierModalForm] = useState(false);
  const [inventoryManagementModalForm, setInventoryManagementModalForm] =
    useState(false);
  const [customerModalEdit, setCustomerModalEdit] = useState(false);
  const [packageModalEdit, setPackageModalEdit] = useState(false);
  const [supplierModalEdit, setSupplierModalEdit] = useState(false);
  const [inventoryManagementModalEdit, setInventoryManagementModalEdit] =
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
                element={
                  <Customers
                    customerStore={customerStore}
                    setModalForm={setCustomerModalForm}
                    setEditModalForm={setCustomerModalEdit}
                  />
                }
              />
              <Route
                path="/suppliers"
                element={
                  <Suppliers
                    suppliersStore={suppliersStore}
                    setModalForm={setSupplierModalForm}
                    setEditModalForm={setSupplierModalEdit}
                  />
                }
              />
              <Route
                path="/packages"
                element={<Packages setModalForm={setPackageModalForm} />}
              />
              <Route
                path="/inventoryManagement"
                element={
                  <InventoryManagement
                    setModalForm={setInventoryManagementModalForm}
                  />
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
      {customerModalForm && (
        <CustomerForm
          customerStore={customerStore}
          closeModalForm={setCustomerModalForm}
        />
      )}
      {packageModalForm && <PackageForm closeModalForm={setPackageModalForm} />}
      {supplierModalForm && (
        <SupplierForm
          closeModalForm={setSupplierModalForm}
          suppliersStore={suppliersStore}
        />
      )}
      {inventoryManagementModalForm && (
        <InventoryManagementForm
          closeModalForm={setInventoryManagementModalForm}
        />
      )}
      {customerModalEdit && (
        <CustomerEdit
          customerStore={customerStore}
          closeModalEdit={setCustomerModalEdit}
        />
      )}
      {packageModalEdit && <PackageEdit closeModalEdit={setPackageModalEdit} />}
      {supplierModalEdit && (
        <SupplierEdit
          closeModalEdit={setSupplierModalEdit}
          suppliersStore={suppliersStore}
        />
      )}
      {inventoryManagementModalEdit && (
        <InventoryManagementEdit
          closeModalEdit={setInventoryManagementModalEdit}
        />
      )}
    </BrowserRouter>
  );
}

export default App;

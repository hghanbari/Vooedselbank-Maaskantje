import "./styles/main.css";
import Cookies from "js-cookie";
import { BrowserRouter, Route, Routes } from "react-router-dom";
import { useState } from "react";
import Login from "./login";
import PasswordReset from "./passwordReset";
import Header from "./header";
import Sidebar from "./sidebar";
import Footer from "./footer";
import Home from "./pages/home";
import Customers from "./pages/customers";
import Suppliers from "./pages/suppliers";
import Packages from "./pages/packages";
import Profile from "./pages/profile";
import UserManager from "./pages/userManager";
import InventoryManagement from "./pages/inventoryManagement";
import CustomerForm from "./components/addForm/CustomerForm";
import UserManagerForm from "./components/addForm/UserManagerForm";
import PackageForm from "./components/addForm/PackageForm";
import SupplierForm from "./components/addForm/SupplierForm";
import InventoryManagementForm from "./components/addForm/InventoryManagementForm";
import CustomerEdit from "./components/editForm/CustomerEdit";
import PackageEdit from "./components/editForm/PackageEdit";
import SupplierEdit from "./components/editForm/SupplierEdit";
import UserManagerEdit from "./components/editForm/UserManagerEdit";
import InventoryManagementEdit from "./components/editForm/InventoryManagementEdit";
import useCustomers from "./states/useCustomers";
import useSupplier from "./states/useSuppliers";
import usePackages from "./states/usePackages";
import useUsers from "./states/useUsers";
import useInventoryManagement from "./states/useInventoryManagement";

function App() {
  const packageStore = usePackages();
  const userStore = useUsers();
  const customersStore = useCustomers();
  const suppliersStore = useSupplier();
  const inventoryManagementStore = useInventoryManagement();

  const [customerModalForm, setCustomerModalForm] = useState(false);
  const [userModalForm, setUserModalForm] = useState(false);
  const [packageModalForm, setPackageModalForm] = useState(false);
  const [supplierModalForm, setSupplierModalForm] = useState(false);
  const [inventoryManagementModalForm, setInventoryManagementModalForm] =
    useState(false);

  const [editCustomer, setEditCustomer] = useState(0);
  const [editUser, setEditUser] = useState(0);
  const [editPackage, setEditPackage] = useState(0);
  const [editSupplier, setEditSupplier] = useState(0);
  const [editInventoryManagement, setEditInventoryManagement] = useState(0);

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
            <Header
              customersStore={customersStore}
              inventoryManagementStore={inventoryManagementStore}
              packageStore={packageStore}
            />
            <Routes>
              <Route path="/" element={<Home />} />
              <Route path="/profile" element={<Profile />} />
              <Route
                path="/userManager"
                element={
                  <UserManager
                    userStore={userStore}
                    setModalForm={setUserModalForm}
                    showEditModal={setEditUser}
                  />
                }
              />
              <Route
                path="/customers"
                element={
                  <Customers
                    customersStore={customersStore}
                    setModalForm={setCustomerModalForm}
                    showEditModal={setEditCustomer}
                  />
                }
              />
              <Route
                path="/suppliers"
                element={
                  <Suppliers
                    suppliersStore={suppliersStore}
                    setModalForm={setSupplierModalForm}
                    showEditModal={setEditSupplier}
                  />
                }
              />
              <Route
                path="/packages"
                element={
                  <Packages
                    setModalForm={setPackageModalForm}
                    showEditModal={setEditPackage}
                    packageStore={packageStore}
                  />
                }
              />
              <Route
                path="/inventoryManagement"
                element={
                  <InventoryManagement
                    showEditModal={setEditInventoryManagement}
                    setModalForm={setInventoryManagementModalForm}
                    inventoryManagementStore={inventoryManagementStore}
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
          <Route path="/passwordReset" element={<PasswordReset />} />
        </Routes>
      )}
      {customerModalForm && (
        <CustomerForm
          customersStore={customersStore}
          closeModalForm={setCustomerModalForm}
        />
      )}
      {userModalForm && (
        <UserManagerForm
          userStore={userStore}
          closeModalForm={setUserModalForm}
        />
      )}
      {packageModalForm && (
        <PackageForm
          closeModalForm={setPackageModalForm}
          packageStore={packageStore}
        />
      )}
      {supplierModalForm && (
        <SupplierForm
          closeModalForm={setSupplierModalForm}
          suppliersStore={suppliersStore}
        />
      )}
      {inventoryManagementModalForm && (
        <InventoryManagementForm
          closeModalForm={setInventoryManagementModalForm}
          inventoryManagementStore={inventoryManagementStore}
        />
      )}
      {editCustomer !== 0 && (
        <CustomerEdit
          customersStore={customersStore}
          id={editCustomer}
          closeModal={() => setEditCustomer(0)}
        />
      )}
      {editPackage !== 0 && (
        <PackageEdit
          closeModal={() => setEditPackage(0)}
          packageStore={packageStore}
          id={editPackage}
        />
      )}
      {editUser !== 0 && (
        <UserManagerEdit
          closeModal={() => setEditUser(0)}
          userStore={userStore}
        />
      )}
      {editSupplier !== 0 && (
        <SupplierEdit
          closeModal={() => setEditSupplier(0)}
          suppliersStore={suppliersStore}
          id={editSupplier}
        />
      )}
      {editInventoryManagement !== 0 && (
        <InventoryManagementEdit
          closeModal={() => setEditInventoryManagement(0)}
          inventoryManagementStore={inventoryManagementStore}
          id={editInventoryManagement}
        />
      )}
    </BrowserRouter>
  );
}

export default App;

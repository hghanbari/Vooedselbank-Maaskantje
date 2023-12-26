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
import ProfileEdit from "./components/editForm/ProfileEdit";
import PackageEdit from "./components/editForm/PackageEdit";
import SupplierEdit from "./components/editForm/SupplierEdit";
import UserManagerEdit from "./components/editForm/UserManagerEdit";
import InventoryManagementEdit from "./components/editForm/InventoryManagementEdit";
import useCustomers from "./states/useCustomers";
import useSupplier from "./states/useSuppliers";
import usePackages from "./states/usePackages";
import useUsers from "./states/useUsers";
import useInventoryManagement from "./states/useInventoryManagement";
// import useProfile from "./states/useProfile";

function App() {
  const packageStore = usePackages();
  // const profileStore = useProfile();
  const userStore = useUsers();
  const customerStore = useCustomers();
  const suppliersStore = useSupplier();
  const inventoryManagementStore = useInventoryManagement();

  const [customerModalForm, setCustomerModalForm] = useState(false);
  const [userModalForm, setUserModalForm] = useState(false);
  const [packageModalForm, setPackageModalForm] = useState(false);
  const [supplierModalForm, setSupplierModalForm] = useState(false);
  const [inventoryManagementModalForm, setInventoryManagementModalForm] =
    useState(false);

  const [profileModalEdit, setProfileModalEdit] = useState(false);
  const [customerModalEdit, setCustomerModalEdit] = useState(false);
  const [userModalEdit, setUserModalEdit] = useState(false);
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
              <Route path="/" element={<Home />} />
              <Route
                path="/profile"
                element={
                  <Profile
                    setEditModalForm={setProfileModalEdit}
                    // profileStore={profileStore}
                  />
                }
              />
              <Route
                path="/userManager"
                element={
                  <UserManager
                    userStore={userStore}
                    setModalForm={setCustomerModalForm}
                    setEditModalForm={setCustomerModalEdit}
                  />
                }
              />
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
                element={
                  <Packages
                    setModalForm={setPackageModalForm}
                    setEditModalForm={setPackageModalEdit}
                    packageStore={packageStore}
                  />
                }
              />
              <Route
                path="/inventoryManagement"
                element={
                  <InventoryManagement
                    setEditModalForm={setInventoryManagementModalEdit}
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
          customerStore={customerStore}
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
      {customerModalEdit && (
        <CustomerEdit
          customerStore={customerStore}
          closeModalEdit={setCustomerModalEdit}
        />
      )}
      {profileModalEdit && (
        <ProfileEdit
          // profileStore={profileStore}
          closeModalEdit={setProfileModalEdit}
        />
      )}
      {packageModalEdit && (
        <PackageEdit
          closeModalEdit={setPackageModalEdit}
          packageStore={packageStore}
        />
      )}
      {userModalEdit && (
        <UserManagerEdit
          closeModalEdit={setUserModalEdit}
          userStore={userStore}
        />
      )}
      {supplierModalEdit && (
        <SupplierEdit
          closeModalEdit={setSupplierModalEdit}
          suppliersStore={suppliersStore}
        />
      )}
      {inventoryManagementModalEdit && (
        <InventoryManagementEdit
          closeModalEdit={setInventoryManagementModalEdit}
          inventoryManagementStore={inventoryManagementStore}
        />
      )}
    </BrowserRouter>
  );
}

export default App;

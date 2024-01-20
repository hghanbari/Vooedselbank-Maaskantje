import axios from "axios";
import { useState, useEffect } from "react";
import ReactPaginate from "react-paginate";

export default function Customers({
  setModalForm,
  showEditModal,
  customersStore,
}) {
  const { customersList, fetchCustomers } = customersStore;
  const [currentItems, setCurrentItems] = useState([]);
  const [itemOffset, setItemOffset] = useState(0);
  const [pageCount, setPageCount] = useState(0);

  const itemsPerPage = 5;

  const handleDelete = (id) => {
    if (window.confirm("Are you sure?")) {
      axios
        .delete(
          "http://localhost/backend/actions/delete/customer.php?id=" + id,
          // "http://localhost/Vooedselbank-Maaskantje/public/php/actions/delete/customer.php?id=" + id,
          {
            withCredentials: true,
          }
        )
        .then((res) => {
          if (res.data.success) {
            alert(res.data.message);
            fetchCustomers();
          }
        })
        .catch((err) => console.log(err));
    }
  };

  const handleEdit = (id) => {
    showEditModal(id);
  };

  useEffect(() => {
    const endOffset = itemOffset + itemsPerPage;
    setCurrentItems(customersList.slice(itemOffset, endOffset));
    setPageCount(Math.ceil(customersList.length / itemsPerPage));
  }, [itemOffset, itemsPerPage, customersList]);

  const handlePageClick = (event) => {
    const newOffset = (event.selected * itemsPerPage) % customersList.length;
    setItemOffset(newOffset);
  };

  return (
    <div className="body-content">
      <div className="header-content">
        <h4 className="header-title">Klanten</h4>
        <button className="header-button" onClick={() => setModalForm(true)}>
          Klant Toevoegen
        </button>
      </div>
      <table className="data-table">
        <thead className="table-header">
          <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>E-mail</th>
            <th>Phone</th>
            <th>Address</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          {currentItems.map((user, index) => {
            return (
              <tr key={index}>
                <td>{user.firstName}</td>
                <td>{user.lastName}</td>
                <td>{user.email}</td>
                <td>{user.phone}</td>
                <td>{user.address}</td>
                <td>
                  <button
                    className="in-table"
                    onClick={handleEdit.bind(this, user.customerId)}>
                    <span className="material-symbols-outlined">edit</span>
                  </button>

                  <button
                    className="in-table"
                    onClick={handleDelete.bind(this, user.customerId)}>
                    <span className="material-symbols-outlined">delete</span>
                  </button>
                </td>
              </tr>
            );
          })}
        </tbody>
      </table>
      <ReactPaginate
        breakLabel="..."
        nextLabel=" >"
        onPageChange={handlePageClick}
        pageRangeDisplayed={itemsPerPage}
        pageCount={pageCount}
        previousLabel="< "
        containerClassName="pagination"
        pageLinkClassName="page-num"
        nextLinkClassName="page-num"
        previousLinkClassName="page-num"
        activeClassName="active"
      />
    </div>
  );
}

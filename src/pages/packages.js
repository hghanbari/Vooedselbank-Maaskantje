import axios from "axios";
import React, { useEffect, useState } from "react";
import ReactPaginate from "react-paginate";

export default function Packages({
  setModalForm,
  setEditModalForm,
  packageStore,
}) {
  const { packagesList, fetchPackages } = packageStore;

  const [currentItems, setCurrentItems] = useState([]);
  const [itemOffset, setItemOffset] = useState(0);
  const [pageCount, setPageCount] = useState(0);

  const itemsPerPage = 5;

  // useEffect(() => {
  //   axios
  //     .get("http://localhost/backend/json/foodPacketJson.php")
  //     .then((res) => {
  //       const myArray = Object.keys(res.data).map((key) => res.data[key]);
  //       console.log(myArray);
  //       setData(myArray);
  //     })
  //     .catch((err) => console.log(err));
  // }, []);

  const handleDelete = (id) => {
    if (window.confirm("Are you sure?")) {
      axios
        .delete(
          "http://localhost/backend/actions/delete/customer.php?id=" + id,
          {
            withCredentials: true,
          }
        )
        .then((res) => {
          if (res.data.success) {
            alert(res.data.message);
            fetchPackages();
          }
        })
        .catch((err) => console.log(err));
    }
  };

  useEffect(() => {
    const endOffset = itemOffset + itemsPerPage;
    setCurrentItems(packagesList.slice(itemOffset, endOffset));
    setPageCount(Math.ceil(packagesList.length / itemsPerPage));
  }, [itemOffset, itemsPerPage, packagesList]);

  const handlePageClick = (event) => {
    const newOffset = (event.selected * itemsPerPage) % packagesList.length;
    setItemOffset(newOffset);
  };

  return (
    <div className="body-content">
      <div className="header-content">
        <h4 className="header-title">Pakketten</h4>
        <button className="header-button" onClick={() => setModalForm(true)}>
          Pakket Toevoegen
        </button>
      </div>
      <table className="data-table">
        <thead className="table-header">
          <tr>
            <th>Make Date</th>
            <th>Pick Up Date</th>
            <th>Customer Name</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          {currentItems.map((user, index) => {
            return (
              <tr key={index}>
                <td>{user.makeDate}</td>
                <td>{user.pickUpDate}</td>
                <td>
                  {/* {user.customer.customerFirstName}
                  {user.customer.customerLastName} */}
                </td>
                <td>
                  <button
                    className="in-table"
                    onClick={() => setEditModalForm(true)}>
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

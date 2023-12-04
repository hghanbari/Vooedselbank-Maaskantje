import React, { useEffect } from "react";
import { useState } from "react";
import axios from "axios";
import ReactPaginate from "react-paginate";

export default function InventoryManagement({ setModal }) {
  const [data, setData] = useState([]);
  const [currentItems, setCurrentItems] = useState([]);
  const [itemOffset, setItemOffset] = useState(0);
  const [pageCount, setPageCount] = useState(0);
  const itemsPerPage = 3;

  useEffect(() => {
    axios
      .get("http://localhost/backend/json/supplierJson.php")
      .then((res) => {
        setData(res.data);
      })
      .catch((err) => console.log(err));
  }, []);

  useEffect(() => {
    const endOffset = itemOffset + itemsPerPage;
    setCurrentItems(data.slice(itemOffset, endOffset));
    setPageCount(Math.ceil(data.length / itemsPerPage));
  }, [itemOffset, itemsPerPage, data]);

  const handlePageClick = (event) => {
    const newOffset = (event.selected * itemsPerPage) % data.length;
    setItemOffset(newOffset);
  };

  return (
    <div className="body-content">
      <div className="header-content">
        <h4 className="header-title">Voorraad</h4>
        <button className="header-button" onClick={() => setModal(true)}>
          Product Toevogen
        </button>
      </div>
      <table className="data-table">
        <thead className="table-header">
          <tr>
            <th>Name</th>
            <th>EAN</th>
            <th>Hoeveelhied</th>
            <th>Sort</th>
            <th>Prijs</th>
          </tr>
        </thead>
        <tbody>
          {currentItems.map((user, index) => {
            return (
              <tr key={index}>
                <td>{user.companyName}</td>
                <td>{user.adress}</td>
                <td>{user.contactName}</td>
                <td>{user.email}</td>
                <td>{user.phone}</td>
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

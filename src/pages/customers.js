import axios from "axios";
import React from "react";
import { useState, useEffect } from "react";
import ReactPaginate from "react-paginate";

export default function Customers() {
  const [data, setData] = useState([{}]);
  const [itemOffset, setItemOffset] = useState(0);
  const [pageCount, setPageCount] = useState(0);
  const [currentItems, setCurrentItems] = useState([]);
  const itemsPerPage = 5;

  useEffect(() => {
    axios
      .get("http://localhost/backend/json/customerJson.php")
      .then((res) => {
        setData(res.data);
      })
      .catch((err) => console.log(err));
  }, []);

  useEffect(() => {
    const endOffset = itemOffset + itemsPerPage;
    setCurrentItems(Object.values(data).slice(itemOffset, endOffset));
    setPageCount(Math.ceil(data.length / itemsPerPage));
  }, [itemOffset, itemsPerPage, data]);

  const handlePageClick = (e) => {
    const newOffset = (e.selected * itemsPerPage) % data.length;
    setItemOffset(newOffset);
  };

  return (
    <div className="body-content">
      <div className="header-content">
        <h4 className="header-title">Klanten</h4>
        <button className="header-button">Klant Toevogen</button>
      </div>
      <table className="data-table">
        <thead className="table-header">
          <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>E-mail</th>
            <th>Phone</th>
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
              </tr>
            );
          })}
        </tbody>
      </table>

      <ReactPaginate
        breakLabel="..."
        nextLabel="next >"
        onPageChange={handlePageClick}
        pageRangeDisplayed={5}
        pageCount={pageCount}
        previousLabel="< previous"
        renderOnZeroPageCount={null}
        containerClassName="pagination"
        pageLinkClassName="page-num"
        nextLinkClassName="page-num"
        previousLinkClassName="page-num"
        activeClassName="active"
      />
    </div>
  );
}

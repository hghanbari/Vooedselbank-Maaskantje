import React, { useEffect, useState } from "react";
import axios from "axios";
import ReactPaginate from "react-paginate";

export default function InventoryManagement({
  setModalForm,
  showEditModal,
  inventoryManagementStore,
}) {
  const { fetchInventoryManagement, inventoryManagementList } =
    inventoryManagementStore;

  const [currentItems, setCurrentItems] = useState([]);
  const [itemOffset, setItemOffset] = useState(0);
  const [pageCount, setPageCount] = useState(0);

  const itemsPerPage = 5;

  const handleDelete = (id) => {
    if (window.confirm("Are you sure?")) {
      axios
        .delete("http://localhost/backend/actions/delete/stock.php?id=" + id, {
        // .delete("http://localhost/Vooedselbank-Maaskantje/public/php/actions/delete/stock.php?id=" + id, {
          withCredentials: true,
        })
        .then((res) => {
          if (res.data.success) {
            alert(res.data.message);
            fetchInventoryManagement();
          }
        })
        .catch((err) => console.log(err));
    }
  };

  const handleEdit = (id) => {
    console.log(id);
    showEditModal(id);
  };

  useEffect(() => {
    const endOffset = itemOffset + itemsPerPage;
    setCurrentItems(inventoryManagementList.slice(itemOffset, endOffset));
    setPageCount(Math.ceil(inventoryManagementList.length / itemsPerPage));
  }, [itemOffset, itemsPerPage, inventoryManagementList]);

  const handlePageClick = (event) => {
    const newOffset =
      (event.selected * itemsPerPage) % inventoryManagementList.length;
    setItemOffset(newOffset);
  };

  return (
    <div className="body-content">
      <div className="header-content">
        <h4 className="header-title">Voorraad</h4>
        <button className="header-button" onClick={() => setModalForm(true)}>
          Product Toevoegen
        </button>
      </div>
      <table className="data-table">
        <thead className="table-header">
          <tr>
            <th>Naam</th>
            <th>EAN</th>
            <th>Hoeveelheid</th>
            <th>Categorie</th>
            <th>houdbaarheidsdatum</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          {currentItems.map((user, index) => {
            return (
              <tr key={index}>
                <td>{user.productInfo.name}</td>
                <td>{user.productInfo.ean}</td>
                <td>{user.amount}</td>
                <td>{user.productInfo.catagoryDesc}</td>
                <td>{user.bestByDate}</td>
                <td>
                  <button
                    className="in-table"
                    onClick={handleEdit.bind(this, user.stockId)}>
                    <span className="material-symbols-outlined">edit</span>
                  </button>

                  <button
                    className="in-table"
                    onClick={handleDelete.bind(
                      this,
                      user.stockId
                    )}>
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

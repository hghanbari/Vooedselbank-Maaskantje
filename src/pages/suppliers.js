import React from "react";
import { useTable } from "react-table";
import { useState } from "react";

export default function Suppliers() {
  const [customers, setCustomers] = useState([]);

  // fetch("http://localhost/backend/json/customerJson.php")
  //   .then((response) => response.json())
  //   .then((data) => {
  //     // customers(data);
  //     // console.log(data);
  //   });

  // Dummy data for demonstration
  const data = React.useMemo(
    () => [
      {},
      // Add more data as needed
    ],
    []
  );

  // Define columns for the datatable
  const columns = React.useMemo(
    () => [
      { Header: "First Name", accessor: "firstName" },
      { Header: "Last Name", accessor: "name" },
      { Header: "Phone", accessor: "phone" },
      { Header: "E-mail", accessor: "email" },
      // Add more columns as needed
    ],
    []
  );

  // Create an instance of the table
  const { getTableProps, getTableBodyProps, headerGroups, rows, prepareRow } =
    useTable({ columns, data });
  return (
    <div className="body-content">
      <div className="header-content">
        <h4 className="header-title">Leveranciers</h4>
        <button className="header-button">Leverancier Toevogen</button>
      </div>
      <table className="data-table">
        <thead className="table-header">
          {headerGroups.map((headerGroup) => (
            <tr {...headerGroup.getHeaderGroupProps()}>
              {headerGroup.headers.map((column) => (
                <th {...column.getHeaderProps()}>{column.render("Header")}</th>
              ))}
            </tr>
          ))}
        </thead>
        <tbody {...getTableBodyProps()}>
          {rows.map((row) => {
            prepareRow(row);
            return (
              <tr {...row.getRowProps()}>
                {row.cells.map((cell) => (
                  <td {...cell.getCellProps()}>{cell.render("Cell")}</td>
                ))}
              </tr>
            );
          })}
        </tbody>
      </table>
      <div className="pagination"></div>
    </div>
  );
}

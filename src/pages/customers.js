import React from "react";
import { useTable } from "react-table";

export default function Customers() {
  // Dummy data for demonstration
  const data = React.useMemo(
    () => [
      { firstName: "John", lastName: "Doe", age: 30 },
      { firstName: "Jane", lastName: "Doe", age: 25 },
      // Add more data as needed
    ],
    []
  );

  // Define columns for the datatable
  const columns = React.useMemo(
    () => [
      { Header: "First Name", accessor: "firstName" },
      { Header: "Last Name", accessor: "lastName" },
      { Header: "Age", accessor: "age" },
      // Add more columns as needed
    ],
    []
  );

  // Create an instance of the table
  const { getTableProps, getTableBodyProps, headerGroups, rows, prepareRow } =
    useTable({ columns, data });

  return (
    <div className="body-content">
      <table {...getTableProps()} className="datatable">
        <thead>
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
    </div>
  );
}

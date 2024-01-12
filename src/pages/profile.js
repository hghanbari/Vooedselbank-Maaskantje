import React from "react";

export default function Profile({ showEditModal, profileStore }) {
  const { profile } = profileStore;

  const handleEdit = (id) => {
    showEditModal(id);
  };

  return (
    <div className="body-content">
      <div className="header-content">
        <h4 className="header-title">profile</h4>
        <button className="header-button" onClick={handleEdit.bind()}>
          profile wijzigen
        </button>
      </div>
      <table className="data-table">
        <thead className="table-header">
          <tr>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Address</th>
            <th>E-mail</th>
            <th>Phone</th>
          </tr>
        </thead>
        <tbody>
          <tr key={profile.id}>
            <td>{profile.firstName}</td>
            <td>{profile.middleName}</td>
            <td>{profile.lastName}</td>
            <td>{profile.address}</td>
            <td>{profile.email}</td>
            <td>{profile.phone}</td>
          </tr>
        </tbody>
      </table>
    </div>
  );
}

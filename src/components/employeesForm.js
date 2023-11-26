import * as React from "react";
import Modal from "react-modal";
import Zoom from "react-awesome-reveal";

export default function EmployeesForm() {
  return (
    <Modal>
      <Zoom>
        <div className="model-content">
          <button className="close-modal" onClick={this.closeModal}>
            x
          </button>
          <form className="form-content">
            <label>Name:</label>
            <input type="text" required></input>
            <label>Name:</label>
            <input type="text" required></input>
          </form>
          <button
            className="button primary"
            onClick={() => {
              this.closeModal();
            }}>
            Add To Cart
          </button>
        </div>
      </Zoom>
    </Modal>
  );
}

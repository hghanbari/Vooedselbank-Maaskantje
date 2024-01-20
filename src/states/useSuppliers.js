import axios from "axios";
import { useEffect, useState } from "react";

const useSupplier = () => {
  const [suppliersList, setSuppliersList] = useState([], []);
  const [timestamp, setTimestamp] = useState(0);

  useEffect(() => {
    axios
      // .get("http://localhost/Vooedselbank-Maaskantje/public/php/json/supplierJson.php")
      .get("http://localhost/backend/json/supplierJson.php")
      .then((res) => {
        const myArray = Object.keys(res.data).map((key) => res.data[key]);
        setSuppliersList(myArray);
      })
      .catch((err) => console.log(err));
  }, [timestamp]);

  function fetchSuppliers() {
    setTimestamp(new Date().getTime());
  }

  return {
    suppliersList,
    fetchSuppliers,
  };
};

export default useSupplier;

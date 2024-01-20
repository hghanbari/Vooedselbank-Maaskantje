import axios from "axios";
import { useEffect, useState } from "react";

const useInventoryManagement = () => {
  const [inventoryManagementList, setInventoryManagement] = useState([], []);
  const [timestamp, setTimestamp] = useState(0);

  useEffect(() => {
    axios
      // .get("http://localhost/Vooedselbank-Maaskantje/public/php/json/stockJson.php")
      .get("http://localhost/backend/json/stockJson.php")
      .then((res) => {
        const myArray = Object.keys(res.data).map((key) => res.data[key]);
        setInventoryManagement(myArray);
      })
      .catch((err) => console.log(err));
  }, [timestamp]);

  function fetchInventoryManagement() {
    setTimestamp(new Date().getTime());
  }

  return {
    inventoryManagementList,
    fetchInventoryManagement,
  };
};

export default useInventoryManagement;

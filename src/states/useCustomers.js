import axios from "axios";
import { useEffect, useState } from "react";

const useCustomers = () => {
  const [customersList, setCustomersList] = useState([], []);
  const [timestamp, setTimestamp] = useState(0);

  useEffect(() => {
    axios
      // .get("http://localhost/Vooedselbank-Maaskantje/public/php/json/customerJson.php")
      .get("http://localhost/backend/json/customerJson.php")
      .then((res) => {
        const myArray = Object.keys(res.data).map((key) => res.data[key]);
        setCustomersList(myArray);
      })
      .catch((err) => console.log(err));
  }, [timestamp]);

  function fetchCustomers() {
    setTimestamp(new Date().getTime());
  }

  return {
    customersList,
    fetchCustomers,
  };
};

export default useCustomers;

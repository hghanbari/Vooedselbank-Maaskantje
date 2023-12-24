import axios from "axios";
import { useEffect, useState } from "react";

const useCustomers = () => {
  const [customerList, setCustomerList] = useState([], []);
  const [timestamp, setTimestamp] = useState(0);

  useEffect(() => {
    axios
      .get("http://localhost/backend/json/customerJson.php")
      .then((res) => {
        const myArray = Object.keys(res.data).map((key) => res.data[key]);
        setCustomerList(myArray);
      })
      .catch((err) => console.log(err));
  }, [timestamp]);

  function fetchCustomers() {
    setTimestamp(new Date().getTime());
  }

  return {
    customerList,
    fetchCustomers,
  };
};

export default useCustomers;

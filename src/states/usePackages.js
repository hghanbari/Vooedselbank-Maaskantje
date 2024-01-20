import axios from "axios";
import { useEffect, useState } from "react";

const usePackages = () => {
  const [customerData, setCustomerData] = useState([]);
  const [productData, setProductData] = useState([]);
  const [packagesList, setPackagesList] = useState([], []);
  const [timestamp, setTimestamp] = useState(0);

  useEffect(() => {
    axios
      .get("http://localhost/backend/json/foodPacketJson.php")
      // .get("http://localhost/Vooedselbank-Maaskantje/public/php/json/foodPacketJson.php")
      .then((res) => {
        const myArray = Object.keys(res.data).map((key) => res.data[key]);
        setPackagesList(myArray);
      })

      .catch((err) => console.log(err));
  }, [timestamp]);

  useEffect(() => {
    axios
      .get("http://localhost/backend/json/customerJson.php")
      // .get("http://localhost/Vooedselbank-Maaskantje/public/php/json/customerJson.php")
      .then((res) => {
        const customer = Object.keys(res.data).map((key) => res.data[key]);
        setCustomerData(customer);
      })
      .catch((err) => console.log(err));
  }, []);

  useEffect(() => {
    axios
      .get("http://localhost/backend/json/productJson.php")
      // .get("http://localhost/Vooedselbank-Maaskantje/public/php/json/productJson.php")
      .then((res) => {
        const productArr = Object.keys(res.data).map((key) => res.data[key]);
        setProductData(productArr);
      })
      .catch((err) => console.log(err));
  }, []);

  function fetchPackages() {
    setTimestamp(new Date().getTime());
  }

  return {
    customerData,
    productData,
    packagesList,
    fetchPackages,
  };
};

export default usePackages;

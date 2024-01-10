import axios from "axios";
import { useEffect, useState } from "react";

const usePackages = () => {
  const [packagesList, setPackagesList] = useState([], []);
  const [timestamp, setTimestamp] = useState(0);

  useEffect(() => {
    axios
      // .get("http://localhost/backend/json/foodPacketJson.php")
      .get("http://localhost/Vooedselbank-Maaskantje/public/php/json/foodPacketJson.php")
      .then((res) => {
        const myArray = Object.keys(res.data).map((key) => res.data[key]);
        setPackagesList(myArray);
      })
      .catch((err) => console.log(err));
  }, [timestamp]);

  function fetchPackages() {
    setTimestamp(new Date().getTime());
  }

  return {
    packagesList,
    fetchPackages,
  };
};

export default usePackages;

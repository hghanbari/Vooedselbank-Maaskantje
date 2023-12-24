import React from "react";
import axios from "axios";
import { useState, useEffect } from "react";

export default function Home() {
  const [data, setData] = useState([]);

  useEffect(() => {
    axios
      .get("http://localhost/backend/json/customerJson.php")
      .then((res) => {
        const myArray = Object.keys(res.data).map((key) => res.data[key]);
        console.log(myArray);
        setData(myArray);
      })
      .catch((err) => console.log(err));
  }, []);

  return <div className="body-content"></div>;
}

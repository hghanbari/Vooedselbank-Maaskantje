import axios from "axios";
import { useEffect, useState } from "react";

const useUsers = () => {
  const [usersList, setUsersList] = useState([], []);
  const [timestamp, setTimestamp] = useState(0);

  useEffect(() => {
    axios
      .get("http://localhost/backend/json/userJson.php")
      // .get("http://localhost/Vooedselbank-Maaskantje/public/php/json/userJson.php")
      .then((res) => {
        const myArray = Object.keys(res.data).map((key) => res.data[key]);
        setUsersList(myArray);
      })
      .catch((err) => console.log(err));
  }, [timestamp]);

  function fetchUsers() {
    setTimestamp(new Date().getTime());
  }

  return {
    usersList,
    fetchUsers,
  };
};

export default useUsers;

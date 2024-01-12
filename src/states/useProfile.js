import axios from "axios";
import { useEffect, useState } from "react";

const useProfile = () => {
  const [profile, setProfile] = useState([], []);
  const [timestamp, setTimestamp] = useState(0);

  useEffect(() => {
    axios
      .get("http://localhost/backend/json/userJson.php")
      .then((res) => {
        const myArray = Object.keys(res.data).map((key) => res.data[key]);
        setProfile(myArray);
      })
      .catch((err) => console.log(err));
  }, [timestamp]);

  function fetchProfile() {
    setTimestamp(new Date().getTime());
  }

  return {
    profile,
    fetchProfile,
  };
};

export default useProfile;

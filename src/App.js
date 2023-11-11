import Header from "./header";
import Sidebar from "./sidebar";
import Footer from "./footer";
import "./styles/main.css";

function App() {
  return (
    <main className="app">
      <link
        rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
      />
      <Sidebar />
      <div className="app-body">
        <Header />
        <div className="body-content">
          <h2 className="main-title">salam</h2>

          <div>
            <div className="circle">
              <span class="material-symbols-outlined">home</span>
            </div>
          </div>
          <h2>salam</h2>
          <h2>salam</h2>
          <h2>salam</h2>
          <h2>salam</h2>
          <h2>salam</h2>
          <h2>salam</h2>
          <h2>salam</h2>
          <h2>salam</h2>
          <h2>salam</h2>
          <h2>salam</h2>
          <h2>salam</h2>
          <h2>salam</h2>
        </div>
        <Footer />
      </div>
    </main>
  );
}

export default App;

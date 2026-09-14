import React from 'react';
import ReactDOM from 'react-dom/client';
import './styles.css';

function App() {
  return (
    <div className="app-shell">
      <header className="topbar">
        <h1>Admin Sena</h1>
        <nav>
          <a href="#">Inicio</a>
          <a href="#">Áreas</a>
          <a href="#">Cursos</a>
          <a href="#">Usuarios</a>
        </nav>
      </header>

      <main className="dashboard">
        <section className="card">
          <h2>Resumen</h2>
          <p>Este proyecto fue separado en backend Laravel y frontend React.</p>
        </section>

        <section className="card">
          <h2>Backend</h2>
          <p>Laravel maneja la lógica, autenticación, modelos y API.</p>
        </section>

        <section className="card">
          <h2>Frontend</h2>
          <p>React gestiona la interfaz y los estilos del cliente.</p>
        </section>
      </main>
    </div>
  );
}

ReactDOM.createRoot(document.getElementById('root')).render(
  <React.StrictMode>
    <App />
  </React.StrictMode>
);

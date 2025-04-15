import { Link } from 'react-router-dom';

function Navbar() {
  return (
    <div className="w-full">
      <div
        className="bg-amber-700 text-black p-4 w-full font-sans flex justify-between items-center"
        style={{ fontFamily: "'Noto Sans KR', sans-serif" }}
      >
        {/* Sección izquierda: navegación */}
        <ul className="list-none flex space-x-6">
          <li className="font-bold hover:text-gray-800">
            <Link to="/patients">Pacientes</Link>
          </li>
          <li className="font-bold hover:text-gray-800">
            <Link to="/records">Fichas</Link>
          </li>
          <li className="font-bold hover:text-gray-800">
            <Link to="/schedules">Turnos</Link>
          </li>
        </ul>

        {/* Sección derecha: opciones */}
        <div className="flex items-center space-x-2">
          <button className="hover: text-blue-300 cursor-pointer">Logear</button>
          <span>o</span>
          <button className="hover: text-blue-900 cursor-pointer">Registrar</button>
        </div>
      </div>
    </div>
  );
}

export default Navbar;


import { BrowserRouter, Route, Routes } from 'react-router-dom';
import './App.css'
import Navbar from './components/shared/Navbar';
import Patients from './pages/Patients';
import Records from './pages/Records';
import Schedules from './pages/Schedules';

function App() {
  return (
    <>
      <BrowserRouter>
        <Navbar />
        <Routes>
          <Route path='/'>
            <Route path='patients' element={ <Patients /> } />
            <Route path='records' element={ <Records /> } />
            <Route path='schedules' element={ <Schedules /> } />
          </Route>
        </Routes>
      </BrowserRouter>
    </>
  );
}

export default App

import { BrowserRouter, Route, Link, Routes } from "react-router-dom"
import Home from "./pages/Home"
import Navbar from "./shared/Navbar"
import Record from "./pages/Record"
import Clients from "./pages/Clients"
import Login from "./pages/Login"
import Register from "./pages/Register"
import Appointment from "./pages/Appointment"

function App() {

  const navItemsLeft = [
    { label: "pacientes", path: "patient/list" },
    { label: "fichas", path: "patient/record" },
    { label: "turnos", path: "patient/appointments" },
  ]

  const navItemsRight = [
    { label: "login", path: "auth/login" },
    { label: "register", path: "auth/register" }
  ]

  return (
    <>
      <BrowserRouter>
        <Navbar
          itemsLeft={navItemsLeft}
          itemsRight={navItemsRight}
        />

        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/patient">
            <Route path="record" element={ <Record /> }/>
            <Route path="list" element={ <Clients /> }/>
            <Route path="appointments" element={ <Appointment /> }/>
          </Route>
          <Route path="/auth">
            <Route path="login" element={<Login />}/>
            <Route path="register" element={<Register />}/>
          </Route>
        </Routes>
      </BrowserRouter>
    </>
  )
}

export default App

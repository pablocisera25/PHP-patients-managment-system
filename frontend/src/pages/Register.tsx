import { useState } from "react"
import logo from "../assets/img/logo.png"
import "../../public/css/register.css"
import { post } from "../services/http"

function Register() {

  const [dataForm, setDataForm] = useState({
    username: "",
    email: "",
    password: "",
    role: "USER"
  })

  const [registring, setRegistring] = useState(false)
  const [error, setError] = useState("")

  const handleChange = (
    e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>
  ) => {
    const {name, value} = e.target
    setDataForm(prev => ({ ...prev, [name]:value }))    
  }

  const saveFunction = async(
    e: React.FormEvent<HTMLFormElement>
  ) => {
    e.preventDefault()
    console.log("Datos para enviar: ", dataForm)
    setRegistring(true)

    try {
      const response = await post<{message: string}>("/user/register", dataForm)

      console.log('Respuesta del backend: ', response)
    } catch (err: any) {
      setError(err.response?.data?.message || "Error en el registro");
      console.error("Error:", err);
    } finally {
      setRegistring(false);
    }

  }

  return (
    <div className="register-form">
      <img src={logo} alt="logo-login" />
      <form onSubmit={saveFunction}>
        <input 
        type="text" 
        name="username" 
        placeholder="usuario"
        value={dataForm.username} 
        onChange={handleChange}/>

        <input 
        type="email" 
        name="email" 
        placeholder="email"
        value={dataForm.email}
        onChange={handleChange}
        />

        <input 
        type="password" 
        name="password"
        placeholder="contraseña"
        value={dataForm.password}
        onChange={handleChange}
        />

        <select
        name="role"
        value={dataForm.role}
        onChange={handleChange}
        >
          <option value="empty" id="empty"></option>
          <option value="ADMIN" id="admin">administrador</option>
          <option value="USER" id="user">usuario</option>
          <option value="GUEST" id="guest">invitado</option>
        </select>

        <button type="submit">{registring? 'enviando...': 'enviar'}</button>

      </form>
    </div>
  )
}

export default Register
import { useEffect, useState } from "react"
import { getData } from "../services/request_methods"

interface Patient {
  id: number;
  name: string;
  dni: string;
  cuit: string;
  address: string;
  phone: string;
  email?: string;
  socialService: string;
}

function Patients() {

  const [data, setData] = useState<Patient[]>([]);
  const [error, setError] = useState('')

  useEffect(() => {
    async function getPatients() {
      try {
        const patients = await getData({ url: '/api/patients/all', method: 'GET' });
        if (!patients) {
          setError('No se han obtenido registros');
          return;
        }
        setData(Array.isArray(patients) ? patients : [patients]);
      } catch (err) {
        setError('Error al obtener pacientes');
        console.error(err);
      }
    }

    getPatients();
  }, [])



  return (
    <div>
      { error && <p>{error}</p>}
      <div className="container">
        existen datos
      </div>
    </div>
  )
}

export default Patients
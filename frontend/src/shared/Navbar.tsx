import React, { useEffect, useState } from 'react'
import { Link } from 'react-router-dom'
import "/public/css/nav.css"

type NavItem = {
  label: string
  path: string
}

type NavbarProps = {
  itemsLeft: NavItem[]
  itemsRight: NavItem[]
}

function Navbar({ itemsLeft, itemsRight }: NavbarProps) {
  const [isLogged, setIsLogged] = useState(false)

  useEffect(() => {
    const logged = localStorage.getItem('logged')
    setIsLogged(logged === 'true') // asumiendo que guardás 'true' como string
  }, [])

  return (
    <div
      id="nav"
      style={{ display: 'flex', justifyContent: 'space-between', padding: '1rem' }}
    >
      <div style={{ display: 'flex', gap: '1rem' }}>
        {itemsLeft.map((item, index) => (
          <Link className='nav-link' key={index} to={item.path}>
            {item.label}
          </Link>
        ))}
      </div>

      <div style={{ display: 'flex', gap: '1rem' }}>
        {!isLogged ? (
          itemsRight.map((item, index) => (
            <Link className='nav-link' key={index} to={item.path}>
              {item.label}
            </Link>
          ))
        ) : (
          <>
            <button>Profile</button>
            <button
              onClick={() => {
                localStorage.removeItem('logged')
                window.location.reload()
              }}
            >
              Salir
            </button>
          </>
        )}
      </div>
    </div>
  )
}

export default Navbar

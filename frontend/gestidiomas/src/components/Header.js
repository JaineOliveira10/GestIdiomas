import React, { useEffect, useState } from 'react';
import api from '../services/api';
import { useNavigate } from 'react-router-dom';
import { useAuth } from "../context/AuthContext";
import './styles/Header.css';

const Header = () => {
    const [user, setUser] = useState('');
    const [error, setError] = useState('');
    const { isAuthenticated, setIsAuthenticated } = useAuth();
    const navigate = useNavigate();

    useEffect(() => {
        const fetchUser = async () => {
          try {
            const token = localStorage.getItem('authToken');
            const response = await api.get('/me', { 
                headers: { 
                    Authorization: `Bearer ${token}` 
                } 
            });
            setUser(response.data);
          } catch (err) {
            setError('Erro ao buscar usuário.');
          }
        };
    
        fetchUser();
      }, []);

    useEffect(() => {
        if (!isAuthenticated) {
            navigate("/login");
        }
    }, [isAuthenticated, navigate]);

 

    const handleLogout = async () => { 
        try {
            
            const token = localStorage.getItem('authToken');

            const response = await api.post('/logout', {}, { 
                headers: {
                    accept: 'application/json', 
                    Authorization: `Bearer ${token}` 
                } 
            });
            localStorage.removeItem('authToken');
            setIsAuthenticated(false);
          } catch (err) {
            setError('Erro ao realizar o logout.');
          }
    };

    return (
        <header className="app-header">
            <h3>Bem-vindo, {user.name}</h3>
            <div className="user">
                <div className="user-info">Olá, {user.name}!</div>
                <button className="logout" onClick={handleLogout}>Sair</button>
            </div>
            {error && <p className="error">{error}</p>}
        </header>
    );
};

export default Header;

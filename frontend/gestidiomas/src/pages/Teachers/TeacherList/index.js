import React, { useEffect, useState } from 'react';
import api from '../../../services/api';
import { useNavigate } from 'react-router-dom';
import './style.css';
import Header from '../../../components/Header';
import Footer from '../../../components/Footer';

const TeacherList = () => {
  const [teachers, setTeachers] = useState([]);
  const [loading, setLoading] = useState(true);
  const [search, setSearch] = useState('');
  const [error, setError] = useState('');
  const [sortConfig, setSortConfig] = useState({ key: 'first_name', direction: 'ascending' }); // Estado para ordenação
  const navigate = useNavigate();

  useEffect(() => {
    const fetchTeachers = async () => {
      try {
        const token = localStorage.getItem('authToken');
        const response = await api.get('/teachers', { 
            headers: { 
                Authorization: `Bearer ${token}` 
            } 
        });
        setTeachers(response.data);
        setLoading(false);
      } catch (err) {
        setError('Erro ao buscar professores.');
        setLoading(false);
      }
    };

    fetchTeachers();
  }, []);

  const handleStart = () => {
    navigate('/dashboard');
  };

  const handleCreateTeacher = () => {
    navigate('/teachers-create');
  };

  const handleEditTeacher = (teacherId) => {
    navigate(`/teachers/${teacherId}/edit`);
  };

  const handleDeleteTeacher = async (teacherId) => {
    const confirmed = window.confirm("Você tem certeza que deseja excluir este professor?");
    if (confirmed) {
      try {
        const token = localStorage.getItem("authToken");
        await api.delete(`/teachers/${teacherId}`, {
          headers: { Authorization: `Bearer ${token}` },
        });
        setTeachers(teachers.filter((teacher) => teacher.id !== teacherId));
      } catch (err) {
        setError("Erro ao excluir estudante.");
      }
    }
  };

  // Função para ordenar os professores
  const sortedTeachers = React.useMemo(() => {
    let sortableTeachers = [...teachers];
    if (sortConfig !== null) {
      sortableTeachers.sort((a, b) => {
        if (a[sortConfig.key] < b[sortConfig.key]) {
          return sortConfig.direction === 'ascending' ? -1 : 1;
        }
        if (a[sortConfig.key] > b[sortConfig.key]) {
          return sortConfig.direction === 'ascending' ? 1 : -1;
        }
        return 0;
      });
    }
    return sortableTeachers;
  }, [teachers, sortConfig]);

  const requestSort = (key) => {
    let direction = 'ascending';
    if (sortConfig.key === key && sortConfig.direction === 'ascending') {
      direction = 'descending';
    }
    setSortConfig({ key, direction });
  };

  // Função para filtrar os professores
  const filteredTeachers = sortedTeachers.filter((teacher) =>
    `${teacher.first_name} ${teacher.last_name}`.toLowerCase().includes(search.toLowerCase()) ||
    teacher.cpf.includes(search)
  );

  if (loading) {
    return <p>Carregando...</p>;
  }

  if (error) {
    return <p>{error}</p>;
  }

  return (
    <>
        <Header />
        <div className="teacher-list-container">
        <div className="header-list">
          <div className="search">
            <input
              type="text"
              id="searchTeacher"
              onChange={(e) => setSearch(e.target.value)}
              placeholder="Pesquisar Por Nome ou CPF"
              value={search}
            />
          </div>
          <div className="buttons-actions">
            <button onClick={handleCreateTeacher}>Inserir Professor</button>
            <button onClick={handleStart}>Início</button>
          </div>
        </div>
        <table>
            <thead>
            <tr>
                <th onClick={() => requestSort('first_name')}>Nome</th>
                <th onClick={() => requestSort('status')}>Status</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            {filteredTeachers.map((teacher) => (
                <tr key={teacher.id}>
                <td>{`${teacher.first_name} ${teacher.last_name}`}</td>
                <td>{teacher.status === 'active' ? 'Ativo' : 'Inativo'}</td>
                <td className="buttons">
                    <button onClick={() => handleEditTeacher(teacher.id)}>Editar</button>
                    <button onClick={() => handleDeleteTeacher(teacher.id)}>Excluir</button>
                </td>
                </tr>
            ))}
            </tbody>
        </table>
        </div>
        <Footer />
    </>
  );
};

export default TeacherList;

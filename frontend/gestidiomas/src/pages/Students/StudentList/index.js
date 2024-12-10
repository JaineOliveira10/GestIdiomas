import React, { useEffect, useState } from "react";
import api from "../../../services/api";
import { useNavigate } from "react-router-dom";
import "./style.css";
import Header from "../../../components/Header";
import Footer from "../../../components/Footer";
import AppointmentModal from "../../../components/AppointmentModal"; // Certifique-se de ajustar o caminho da importação

const StudentList = () => {
  const [students, setStudents] = useState([]);
  const [search, setSearch] = useState("");
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState("");
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [selectedStudentId, setSelectedStudentId] = useState(null);
  const [selectedStudentName, setSelectedStudentName] = useState(null);
  const navigate = useNavigate();

  useEffect(() => {
    const fetchStudents = async () => {
      try {
        const token = localStorage.getItem("authToken");
        const response = await api.get("/students", {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        setStudents(response.data);
        setLoading(false);
      } catch (err) {
        setError("Erro ao buscar estudantes.");
        setLoading(false);
      }
    };

    fetchStudents();
  }, []);

  const handleStart = () => {
    navigate('/dashboard');
  };

  const handleCreateStudent = () => {
    navigate('/students-create');
  };

  const handleEditStudent = (studentId) => {
    navigate(`/students/${studentId}/edit`);
  };

  const handleDeleteStudent = async (studentId) => {
    const confirmed = window.confirm("Você tem certeza que deseja excluir este aluno?");
    if (confirmed) {
      try {
        const token = localStorage.getItem("authToken");
        await api.delete(`/students/${studentId}`, {
          headers: { Authorization: `Bearer ${token}` },
        });
        setStudents(students.filter((student) => student.id !== studentId));
      } catch (err) {
        setError("Erro ao excluir estudante.");
      }
    }
  };

  const handleOpenModal = (studentId, studentName) => {
    setSelectedStudentId(studentId);
    setSelectedStudentName(studentName);
    setIsModalOpen(true);
  };

  const handleCloseModal = () => {
    setIsModalOpen(false);
  };

  const handleSubmit = (appointmentData) => {
    // Faça a requisição POST para a API com os dados do agendamento
    fetch('http://localhost/api/appointments', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(appointmentData)
    })
    .then(response => response.json())
    .then(data => {
      console.log('Agendamento realizado com sucesso:', data);
      // Fechar o modal e resetar o formulário (se necessário)
      handleCloseModal();
    })
    .catch((error) => {
      console.error('Erro ao realizar o agendamento:', error);
    });
  };

  const filteredStudents = students.filter((student) =>
    (`${student.first_name} ${student.last_name}`)
      .toLowerCase()
      .includes(search.toLowerCase())
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
      <div className="student-list-container">
        <div className="header-list">
          <div className="search">
            <input
              type="text"
              id="searchStudent"
              onChange={(e) => setSearch(e.target.value)}
              placeholder="Pesquisar Por Nome"
              value={search}
            />
          </div>
          <div className="buttons-actions">
            <button onClick={handleCreateStudent}>Inserir Aluno</button>
            <button onClick={handleStart}>Início</button>
          </div>
        </div>
        <table>
          <thead>
            <tr>
              <th>Nome</th>
              <th>WhatsApp</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            {filteredStudents.map((student) => (
              <tr key={student.id}>
                <td>{`${student.first_name} ${student.last_name}`}</td>
                <td>
                  <a
                    href={`https://api.whatsapp.com/send/?phone=${student.whatsapp}`}
                    target="_blank"
                    rel="noopener noreferrer"
                  >
                    {student.whatsapp}
                  </a>
                </td>
                <td className="buttons">
                  <button onClick={() => handleEditStudent(student.id)}>
                    Editar
                  </button>
                  <button onClick={() => handleDeleteStudent(student.id)}>
                    Excluir
                  </button>
                  <button onClick={() => handleOpenModal(student.id, student.first_name)}>
                    Agendar
                  </button>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
      <Footer />
      <AppointmentModal
        isOpen={isModalOpen}
        onRequestClose={handleCloseModal}
        onSubmit={handleSubmit}
        studentId={selectedStudentId}
        studentName={selectedStudentName}
      />
    </>
  );
};

export default StudentList;

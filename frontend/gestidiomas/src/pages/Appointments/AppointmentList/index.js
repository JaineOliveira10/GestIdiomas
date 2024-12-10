import React, { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { format } from 'date-fns';
import api from '../../../services/api'; 
import Header from '../../../components/Header'; 
import Footer from '../../../components/Footer'; 
import AppointmentModal from '../../../components/AppointmentModal'; 
import './style.css';

const AppointmentList = () => {
  const [appointments, setAppointments] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [selectedAppointment, setSelectedAppointment] = useState(null);
  const navigate = useNavigate();

  const fetchAppointments = async () => {
    try {
      const token = localStorage.getItem("authToken");
      const response = await api.get("/appointments", {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      });
      setAppointments(response.data);
      setLoading(false);
    } catch (err) {
      setError("Erro ao buscar agendamentos.");
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchAppointments();
  }, []);

  useEffect(() => {
    fetchAppointments();
  }, [isModalOpen]);

  const handleOpenModal = (appointment) => {
    setSelectedAppointment(appointment);
    setIsModalOpen(true);
  };

  const handleCreateAppointment = () => {
    setSelectedAppointment(null); 
    setIsModalOpen(true);
  };

  const handleCloseModal = () => {
    setSelectedAppointment(null);
    setIsModalOpen(false);
  };

  const handleStart = () => {
    navigate('/dashboard');
  };

  const handleSubmit = async (appointmentData) => {
    try {
      await fetchAppointments(); 
      handleCloseModal();
    } catch (error) {
      console.error("Erro ao atualizar a listagem de agendamentos:", error);
    }
  };

  const handleCancelAppointment = async (appointmentId) => {
    const confirmed = window.confirm("Você tem certeza que deseja cancelar este agendamento?");
    if (confirmed) {
      try {
        const token = localStorage.getItem("authToken");
        await api.delete(`/appointments/${appointmentId}`, {
          headers: { Authorization: `Bearer ${token}` },
        });
        setAppointments(appointments.filter((appointment) => appointment.id !== appointmentId));
      } catch (err) {
        setError("Erro ao excluir estudante.");
      }
    }
  }

  if (loading) {
    return <p>Carregando...</p>;
  }

  if (error) {
    return <p>{error}</p>;
  }

  return (
    <>
      <Header />
      <div className="appointment-list-container">
        <div className="buttons-actions">
        <button onClick={handleCreateAppointment}>Realizar Agendamento</button>
          <button onClick={handleStart}>Início</button>
        </div>
        <table>
          <thead>
            <tr>
              <th>Nome do Aluno</th>
              <th>WhatsApp</th>
              <th>Data e Hora</th>
              <th>Conteúdo da Aula</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            {appointments.map((appointment) => (
              <tr key={appointment.id}>
                <td>{`${appointment.student.first_name} ${appointment.student.last_name}`}</td>
                <td>
                  <a
                    href={`https://api.whatsapp.com/send/?phone=${appointment.student.whatsapp}`}
                    target="_blank"
                    rel="noopener noreferrer"
                  >
                    {appointment.student.whatsapp}
                  </a>
                </td>
                <td>{format(appointment.scheduled_at, 'dd/MM/yyyy hh:mm')}</td>
                <td>{appointment.lesson_content}</td>
                <td className="buttons">
                  <button onClick={() => handleOpenModal(appointment)}>Editar</button>
                  <button onClick={() => handleCancelAppointment(appointment.id)}>Cancelar</button>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
        {isModalOpen && (
          <AppointmentModal
            isOpen={isModalOpen}
            onRequestClose={handleCloseModal}
            onSubmit={handleSubmit}
            studentId={selectedAppointment ? selectedAppointment.student.id : ''}
            studentName={selectedAppointment ? `${selectedAppointment.student.first_name} ${selectedAppointment.student.last_name}` : ''}
            appointment={selectedAppointment} 
          />
        )}
      </div>
      <Footer />
    </>
  );
};

export default AppointmentList;

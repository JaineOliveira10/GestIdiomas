import React, { useState, useEffect } from "react";
import Modal from "react-modal";
import api from "../services/api";
import { useNavigate } from "react-router-dom";
import "./styles/AppointmentModal.css";

Modal.setAppElement("#root");

const AppointmentModal = ({
  isOpen,
  onRequestClose,
  onSubmit,
  studentId,
  studentName,
  appointment, // Agendamento existente, se houver
}) => {
  const [studentSelected,setStudentSelected] = useState('');
  const [teacherId, setTeacherId] = useState(appointment ? appointment.teacher_id : "");
  const [scheduledAt, setScheduledAt] = useState(appointment ? appointment.scheduled_at : "");
  const [lessonContent, setLessonContent] = useState(appointment ? appointment.lesson_content : "");
  const [students, setStudents] = useState([]);
  const [teachers, setTeachers] = useState([]);
  const [error, setError] = useState('');


  const navigate = useNavigate();

  useEffect(() => {
    const fetchTeachers = async () => {
      try {
        const token = localStorage.getItem("authToken");
        const response = await api.get("/teachers", {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        setTeachers(response.data);
      } catch (error) {
        console.error("Erro ao buscar professores:", error);
      }
    };

    fetchTeachers();
  }, []);

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
      } catch (error) {
        console.error("Erro ao buscar alunos:", error);
      }
    };

    fetchStudents();
  }, []);

  const handleSubmit = async (e) => {
    e.preventDefault();
    const appointmentData = {
      student_id: studentId ? studentId : studentSelected,
      teacher_id: parseInt(teacherId),
      scheduled_at: scheduledAt,
      lesson_content: lessonContent,
    };

    console.log(appointmentData);

    try {
      const token = localStorage.getItem("authToken");
      if (appointment) {
        console.log(`appointment.id ${appointment.id}`);
        await api.put(`/appointments/${appointment.id}`, appointmentData, {
          headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "application/json",
          },
        });
        alert("Agendamento atualizado com sucesso!");
        onRequestClose();
      } else {
        await api.post("/appointments", appointmentData, {
          headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "application/json",
          },
        });
        alert("Agendamento realizado com sucesso!");
        onSubmit(appointmentData);
        onRequestClose();
        navigate("/appointments");
      }
    } catch (error) {
      const errorMessage = error.response?.data?.message || "Erro desconhecido";
      alert(`Erro ao realizar o agendamento: ${errorMessage}`);
    }
  };

  return (
    <Modal
      isOpen={isOpen}
      onRequestClose={onRequestClose}
      contentLabel="Agendar Aula"
      className="modal"
      overlayClassName="overlay"
    >
      <h2>{appointment ? "Editar Agendamento" : "Agendar Aula"}</h2>
      <form onSubmit={handleSubmit}>

        { studentId &&
          <>
            <input type="hidden" value={studentId } readOnly />

            <input type="text" value={studentName} readOnly />
          </>
        }
        { !studentId &&
          <select
            value={studentSelected}
            onChange={(e) => setStudentSelected(e.target.value)}
            required
          >
            <option value="">Selecione um Aluno</option>
            {students.map((student) => (
              <option key={student.id} value={student.id}>
                {`${student.first_name} ${student.last_name}`}
              </option>
            ))}
          </select>
        }

        <select
          value={teacherId}
          onChange={(e) => setTeacherId(e.target.value)}
          required
        >
          <option value="">Selecione um Professor</option>
          {teachers.map((teacher) => (
            <option key={teacher.id} value={teacher.id}>
              {`${teacher.first_name} ${teacher.last_name}`}
            </option>
          ))}
        </select>

        <input
          type="datetime-local"
          value={scheduledAt}
          onChange={(e) => setScheduledAt(e.target.value)}
          required
        />

        <input
          type="text"
          value={lessonContent}
          onChange={(e) => setLessonContent(e.target.value)}
          placeholder="Aula *"
          required
        />

        <button type="submit">{appointment ? "Atualizar" : "Agendar"}</button>
        <button type="button" onClick={onRequestClose}>
          Cancelar
        </button>
      </form>
    </Modal>
  );
};

export default AppointmentModal;

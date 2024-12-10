import React, { useState, useEffect } from "react";
import { useParams, useNavigate } from 'react-router-dom';
import api from "../../../services/api";
import StudentForm from "../../../components/StudentForm";

const StudentEdit = () => {
  const { studentId } = useParams();
  const navigate = useNavigate();
  const [student, setStudent] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');

  useEffect(() => {
    const fetchStudent = async () => {
      try {
        const token = localStorage.getItem('authToken');
        const response = await api.get(`/students/${studentId}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        setStudent(response.data);
        setLoading(false);
      } catch (err) {
        setError('Erro ao buscar o aluno.');
        setLoading(false);
      }
    };

    fetchStudent();
  }, [studentId]);

  if (loading) {
    return <p>Carregando...</p>;
  }

  if (error) {
    return <p>{error}</p>;
  }

  return (
    <StudentForm initialData={student} onSubmit={(data) => {
      console.log('Aluno atualizado:', data);
      navigate('/students');
    }} />
  );
};

export default StudentEdit;

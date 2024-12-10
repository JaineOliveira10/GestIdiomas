import React, { useState, useEffect } from "react";
import { useParams, useNavigate } from 'react-router-dom';
import api from "../../../services/api";
import TeacherForm from "../../../components/TeacherForm";

const TeacherEdit = () => {
  const { teacherId } = useParams();
  const navigate = useNavigate();
  const [teacher, setTeacher] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');

  useEffect(() => {
    const fetchTeacher = async () => {
      try {
        const token = localStorage.getItem('authToken');
        const response = await api.get(`/teachers/${teacherId}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        setTeacher(response.data);
        setLoading(false);
      } catch (err) {
        setError('Erro ao buscar professor.');
        setLoading(false);
      }
    };

    fetchTeacher();
  }, [teacherId]);

  if (loading) {
    return <p>Carregando...</p>;
  }

  if (error) {
    return <p>{error}</p>;
  }

  return (
    <TeacherForm initialData={teacher} onSubmit={(data) => {
      console.log('Professor atualizado:', data);
      navigate('/teachers');
    }} />
  );
};

export default TeacherEdit;

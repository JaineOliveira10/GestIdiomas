import React from "react";
import { useNavigate } from 'react-router-dom';
import TeacherForm from "../../../components/TeacherForm";


const TeacherCreate = () => {
  const navigate = useNavigate(); 
  const handleFormSubmit = (data) => { console.log('Professor criado:', data); 
    navigate('/teachers'); };

  return (
    <>
      <TeacherForm onSubmit={handleFormSubmit} />
    </>
  );
};

export default TeacherCreate;

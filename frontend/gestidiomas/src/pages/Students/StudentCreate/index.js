import React from "react";
import { useNavigate } from 'react-router-dom';
import StudentForm from "../../../components/StudentForm";


const StudentCreateEdit = () => {
  const navigate = useNavigate(); 
  const handleFormSubmit = (data) => { console.log('Aluno criado:', data); 
    navigate('/students'); };

  return (
    <>
      <StudentForm onSubmit={handleFormSubmit} />
    </>
  );
};

export default StudentCreateEdit;

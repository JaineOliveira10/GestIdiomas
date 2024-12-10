import React from 'react';
import { useNavigate } from 'react-router-dom';
import Header from '../../components/Header';
import Section from '../../components/Section';
import Footer from '../../components/Footer';
import './style.css';

function App() {
    const navigate = useNavigate();

    const handleStudentsClick = () => { 
        navigate(`/students`); 
    };

    const handleAppointmentsClick = () => { 
        navigate(`/appointments`); 
    };

    const handleTeachersClick = () => { 
        navigate(`/teachers`); 
    };

    return (
        <>
            <Header />
            <div className="app">
                
                <div className="main">
                    <Section title="Gestão de Estudantes" description="Gerencie registros e informações dos estudantes." onClick={() => handleStudentsClick()}/>
                    <Section title="Gestão de Agendamento do Estudante" description="Visualize os horários dos estudantes." onClick={() => handleAppointmentsClick()}/>
                    <Section title="Gestão de Professores" description="Visualize e gerencie perfis de professores." onClick={() => handleTeachersClick()}/>
                </div>
            </div>
            <Footer />
        </>
    );
}

export default App;

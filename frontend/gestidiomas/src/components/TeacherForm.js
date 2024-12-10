import React, { useState, useEffect } from "react";
import { useNavigate, useParams } from "react-router-dom";
import api from "../services/api";
import "./styles/Form.css";
import Header from "../components/Header";
import Footer from "../components/Footer";

const StudentForm = ({ initialData = {}, onSubmit }) => {
  const navigate = useNavigate();
  const { teacherId } = useParams();
  const [cpf, setCpf] = useState(initialData.cpf || "");
  const [firstName, setFirstName] = useState(initialData.first_name || "");
  const [lastName, setLastName] = useState(initialData.last_name || "");
  const [birthDate, setBirthDate] = useState(initialData.birth_date || "");
  const [status, setStatus] = useState(initialData.status || "active");
  const [error, setError] = useState("");
  const [success, setSuccess] = useState("");
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    if (teacherId) {
      const fetchTeacher = async () => {
        try {
          const token = localStorage.getItem("authToken");
          const response = await api.get(`/teachers/${teacherId}`, {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          });
          const teacher = response.data;
          setCpf(teacher.cpf);
          setFirstName(teacher.first_name);
          setLastName(teacher.last_name);
          setBirthDate(teacher.birth_date);
          setStatus(teacher.status);
          setLoading(false);
        } catch (err) {
          setError("Erro ao buscar o professor.");
          setLoading(false);
        }
      };

      fetchTeacher();
    } else {
      setLoading(false);
    }
  }, [teacherId]);

  const handleSubmit = async (e) => {
    e.preventDefault();
    const formData = {
      cpf,
      first_name: firstName,
      last_name: lastName,
      birth_date: birthDate,
      status: status,
    };

    try {
      const token = localStorage.getItem("authToken");
      let response;
      if (teacherId) {
        response = await api.put(`/teachers/${teacherId}`, formData, {
          headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
          },
        });
      } else {
        response = await api.post("/teachers", formData, {
          headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
          },
        });
      }

      if (onSubmit) {
        onSubmit(response.data);
      }
      setSuccess(
        teacherId
          ? "Professor atualizado com sucesso!"
          : "Professor criado com sucesso!"
      );
      navigate("/teachers");

    } catch (error) {
      console.log(error)
      alert(`Erro ao salvar professor: ${error.response.data.message}`);
      setError("Erro ao salvar professor.");
    }
  };

  if (loading) {
    return <p>Carregando...</p>;
  }

  return (
    <>
      <Header />
      <form className="student-form" onSubmit={handleSubmit}>
        <div className="form-section">
          <h2>{teacherId ? "Editar Professor" : "Cadastro Professor"}</h2>
          <p>Dados Pessoais</p>
          <div className="form-group">
            <input
              type="text"
              id="cpf"
              value={cpf}
              placeholder="CPF *"
              onChange={(e) => setCpf(e.target.value)}
              required
              readOnly={!!teacherId}
            />
          </div>
          <div className="row-active">
            <div className="form-group column-1">
              <input
                type="text"
                id="firstName"
                value={firstName}
                placeholder="Nome *"
                onChange={(e) => setFirstName(e.target.value)}
                required
              />
            </div>
            <div className="form-group column-2">
              <input
                type="text"
                id="lastName"
                value={lastName}
                placeholder="Sobrenome *"
                onChange={(e) => setLastName(e.target.value)}
                required
              />
            </div>
          </div>
          <div className="row-active">
            <div className="form-group column-1">
              <input
                type="date"
                id="birthDate"
                value={birthDate}
                placeholder="Data de Nascimento"
                onChange={(e) => setBirthDate(e.target.value)}
              />
            </div>
            <div className="column-2">
              <input
                type="checkbox"
                id="status"
                checked={status === "active"}
                onChange={(e) =>
                  setStatus(e.target.checked ? "active" : "inactive")
                }
              />
              <label htmlFor="status">Ativo</label>
            </div>
          </div>
        </div>
        <div className="buttons-container">
          <button type="submit">Salvar</button>
        </div>
        {error && <p className="error">{error}</p>}
        {success && <p className="success">{success}</p>}
      </form>
      <Footer />
    </>
  );
};

export default StudentForm;

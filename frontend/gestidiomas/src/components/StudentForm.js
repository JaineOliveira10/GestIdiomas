import React, { useState, useEffect } from "react";
import { useNavigate, useParams } from 'react-router-dom';
import api from "../services/api";
import "./styles/Form.css";
import Header from "../components/Header";
import Footer from "../components/Footer";

const StudentForm = ({ initialData = {}, onSubmit }) => {
  const navigate = useNavigate();
  const { studentId } = useParams();
  const [cpf, setCpf] = useState(initialData.cpf || "");
  const [firstName, setFirstName] = useState(initialData.first_name || "");
  const [lastName, setLastName] = useState(initialData.last_name || "");
  const [birthDate, setBirthDate] = useState(initialData.birth_date || "");
  const [cep, setCep] = useState(initialData.cep || "");
  const [address, setAddress] = useState(initialData.address || "");
  const [addressNumber, setAddressNumber] = useState(initialData.address_number || "");
  const [neighborhood, setNeighborhood] = useState(initialData.neighborhood || "");
  const [state, setState] = useState(initialData.state || "");
  const [city, setCity] = useState(initialData.city || "");
  const [phone, setPhone] = useState(initialData.phone || "");
  const [whatsapp, setWhatsapp] = useState(initialData.whatsapp || "");
  const [email, setEmail] = useState(initialData.email || "");
  const [error, setError] = useState("");
  const [success, setSuccess] = useState("");
  const [loading, setLoading] = useState(true); 

  useEffect(() => {
    if (studentId) {
      const fetchStudent = async () => {
        try {
          console.log(`Fetching data for student ID: ${studentId}`); 
          const token = localStorage.getItem("authToken");
          const response = await api.get(`/students/${studentId}`, {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          });
          const student = response.data;
          console.log('Student data:', student);  
          setCpf(student.cpf);
          setFirstName(student.first_name);
          setLastName(student.last_name);
          setBirthDate(student.birth_date);
          setCep(student.cep);
          setAddress(student.address);
          setAddressNumber(student.address_number);
          setNeighborhood(student.neighborhood);
          setState(student.state);
          setCity(student.city);
          setPhone(student.phone);
          setWhatsapp(student.whatsapp);
          setEmail(student.email);
          setLoading(false);  
        } catch (err) {
          console.error("Erro ao buscar o aluno:", err); 
          setError("Erro ao buscar o aluno.");
          setLoading(false);  
        }
      };

      fetchStudent();
    } else {
      setLoading(false);  
    }
  }, [studentId]);

  const handleSubmit = async (e) => {
    e.preventDefault();
    const formData = {
      cpf,
      first_name: firstName,
      last_name: lastName,
      birth_date: birthDate || null,
      cep,
      address,
      address_number: addressNumber,
      neighborhood,
      state,
      city,
      phone: phone || null,
      whatsapp,
      email: email || null,
    };

    try {
      const token = localStorage.getItem("authToken");
      let response;
      if (studentId) {
        response = await api.put(`/students/${studentId}`, formData, {
          headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
          },
        });
      } else {
        response = await api.post("/students", formData, {
          headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
          },
        });
      }

      if (onSubmit) {
        onSubmit(response.data);
      }
      setSuccess(studentId ? "Aluno atualizado com sucesso!" : "Aluno criado com sucesso!");
      navigate("/students");
    } catch (error) {
      console.error("Erro ao salvar aluno:", error);
      setError("Erro ao salvar aluno.");
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
          <h2>{studentId ? "Editar Aluno" : "Cadastro Aluno"}</h2>
          <p>Dados Pessoais</p>
          <div className="form-group">
            <input
              type="text"
              id="cpf"
              value={cpf}
              placeholder="CPF *"
              onChange={(e) => setCpf(e.target.value)}
              required
              readOnly={!!studentId}
            />
          </div>
          <div className="row">
            <div className="form-group">
              <input
                type="text"
                id="firstName"
                value={firstName}
                placeholder="Nome *"
                onChange={(e) => setFirstName(e.target.value)}
                required
              />
            </div>
            <div className="form-group">
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
          <div className="form-group">
            <input
              type="date"
              id="birthDate"
              value={birthDate}
              placeholder="Data de Nascimento"
              onChange={(e) => setBirthDate(e.target.value)}
            />
          </div>
        </div>
        <div className="form-section">
          <p>Endereço</p>
          <div className="form-group">
            <input
              type="text"
              id="cep"
              value={cep}
              placeholder="CEP *"
              onChange={(e) => setCep(e.target.value)}
              required
            />
          </div>
          <div className="row">
            <div className="form-group">
              <input
                type="text"
                id="address"
                value={address}
                placeholder="Endereço *"
                onChange={(e) => setAddress(e.target.value)}
                required
              />
            </div>
            <div className="form-group">
              <input
                type="text"
                id="addressNumber"
                value={addressNumber}
                placeholder="Número *"
                onChange={(e) => setAddressNumber(e.target.value)}
                required
              />
            </div>
            <div className="form-group">
              <input
                type="text"
                id="neighborhood"
                value={neighborhood}
                placeholder="Bairro *"
                onChange={(e) => setNeighborhood(e.target.value)}
                required
              />
            </div>
          </div>
          <div className="row">
            <div className="form-group">
              <input
                type="text"
                id="state"
                value={state}
                placeholder="Estado *"
                onChange={(e) => setState(e.target.value)}
                required
              />
            </div>
            <div className="form-group">
              <input
                type="text"
                id="city"
                value={city}
                placeholder="Cidade *"
                onChange={(e) => setCity(e.target.value)}
                required
              />
            </div>
          </div>
          <div className="form-section">
            <p>Contatos</p>
            <div className="row">
              <div className="form-group wide">
                <input
                  type="text"
                  id="phone"
                  value={phone}
                  placeholder="Telefone/Celular"
                  onChange={(e) => setPhone(e.target.value)}
                />
              </div>
              <div className="form-group wide">
                <input
                  type="text"
                  id="whatsapp"
                  value={whatsapp}
                  placeholder="WhatsApp *"
                  onChange={(e) => setWhatsapp(e.target.value)}
                  required
                />
              </div>
              <div className="form-group wide">
                <input
                  type="email"
                  id="email"
                  value={email}
                  placeholder="E-mail"
                  onChange={(e) => setEmail(e.target.value)}
                />
              </div>
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

import React from 'react';
import './styles/Section.css';

const Section = ({ title, description, onClick }) => {
  return (

    <div className="section">
      <h2>{title}</h2>
      <p>{description}</p>
      <button onClick={onClick}>Acessar</button>
    </div>
  );
};

export default Section;

import React from 'react';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import './App.css';
import { AuthProvider } from './context/AuthContext';
import Login from './pages/Login';
import StudentList from './pages/Students/StudentList';
import StudentCreate from './pages/Students/StudentCreate';
import StudentEdit from './pages/Students/StudentEdit';
import TeacherList from './pages/Teachers/TeacherList';
import TeacherCreate from './pages/Teachers/TeacherCreate';
import TeacherEdit from './pages/Teachers/TeacherEdit';
import AppointmentList from './pages/Appointments/AppointmentList';
import Dashboard from './pages/Dashboard'; 
import ProtectedRoute from './components/ProtectedRoute';

function App() {
  return (
    <AuthProvider>
      <Router>
        <div className="App">
          <main>
            <Routes>
              <Route path="/login" element={<Login />} />
              <Route path="/dashboard" element={<ProtectedRoute element={<Dashboard />} />} />
              <Route path="/students" element={<ProtectedRoute element={<StudentList />} />} />
              <Route path="/students-create" element={<ProtectedRoute element={<StudentCreate />} />} />
              <Route path="/students/:studentId/edit" element={<ProtectedRoute element={<StudentEdit />} />} />
              <Route path="/teachers" element={<ProtectedRoute element={<TeacherList />} />} />
              <Route path="/teachers-create" element={<ProtectedRoute element={<TeacherCreate />} />} />
              <Route path="/teachers/:teacherId/edit" element={<ProtectedRoute element={<TeacherEdit />} />} />
              <Route path="/appointments" element={<ProtectedRoute element={<AppointmentList />} />} />
              <Route path="/" element={<Login />} />
            </Routes>
          </main>
        </div>
      </Router>
    </AuthProvider>
  );
}

export default App;

import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import { AuthProvider } from '@context/AuthContext';
import { ToastProvider } from '@context/ToastContext';
import Layout from '@components/Layout';
import Home from '@pages/Home';
import Formaciones from '@pages/Formaciones';
import Portfolio from '@pages/Portfolio';
import Login from '@pages/Login';

function App() {
  return (
    <Router>
      <AuthProvider>
        <ToastProvider>
          <Layout>
            <Routes>
              <Route path="/" element={<Home />} />
              <Route path="/formacion" element={<Formaciones />} />
              <Route path="/cartera" element={<Portfolio />} />
              <Route path="/login" element={<Login />} />
            </Routes>
          </Layout>
        </ToastProvider>
      </AuthProvider>
    </Router>
  );
}

export default App;

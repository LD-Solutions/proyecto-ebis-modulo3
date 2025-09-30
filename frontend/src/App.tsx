import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import Layout from './components/Layout';
import Home from './pages/Home';
import Formaciones from './pages/Formaciones';

function App() {
  return (
    <Router>
      <Layout>
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/formacion" element={<Formaciones />} />
        </Routes>
      </Layout>
    </Router>
  );
}

export default App;

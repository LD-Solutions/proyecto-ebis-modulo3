import React, { ReactNode } from 'react';
import Navbar from '@components/Navbar';
import Footer from '@components/Footer';

interface LayoutProps {
    children: ReactNode;
}

const Layout: React.FC<LayoutProps> = ({ children }) => {
    return (
        <>
            <Navbar />
            {children}
            <Footer />
        </>
    );
};

export default Layout;
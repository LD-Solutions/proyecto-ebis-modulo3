import React, { useEffect } from 'react';
import styles from './Toast.module.css';

interface ToastProps {
  message: string;
  onClose: () => void;
  duration?: number;
}

const Toast: React.FC<ToastProps> = ({ message, onClose, duration = 3000 }) => {
  useEffect(() => {
    const timer = setTimeout(() => {
      onClose();
    }, duration);

    return () => clearTimeout(timer);
  }, [duration, onClose]);

  return (
    <>
      <div className={styles.backdrop} />
      <div className={styles.toastContainer}>
        <div className={styles.toast}>
          <p className={styles.message}>{message}</p>
        </div>
      </div>
    </>
  );
};

export default Toast;
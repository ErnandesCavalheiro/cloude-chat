import React, { useState } from 'react';
import axios from 'axios';
import { CircularProgress } from '@mui/material';

const UserInput = (props) => {
  const [inputText, setInputText] = useState('');
  const [isLoading, setIsLoading] = useState(false);

  const handleInputChange = (e) => {
    setInputText(e.target.value);
  };

  const handleSendMessage = async () => {
    if (inputText.trim() !== '' && !isLoading) {
      const userMessage = inputText;
      setInputText('');
      props.onMessageSent(userMessage);
      setIsLoading(true);
      try {
        const response = await axios.post('http://localhost:8000/chat/send-message', {
          message: userMessage
        });

        if (response.data) {
          props.onMessageReceived(response.data.response);
        }
      } catch (error) {
        console.error('Erro ao enviar mensagem para o backend:', error);
      } finally {
        setIsLoading(false);
      }
    }
  };

  return (
    <div className="user-input">
      <input
        type="text"
        placeholder="Digite sua mensagem..."
        value={inputText}
        onChange={handleInputChange}
      />
      <button onClick={handleSendMessage} disabled={isLoading}>
        {isLoading ? <CircularProgress size={24} color="inherit" /> : 'Enviar'}
      </button>
    </div>
  );
};

export default UserInput;

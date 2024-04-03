import React, { useState } from 'react';
import Message from '../../Components/Message';
import UserInput from '../../Components/UserInput';
import './Chat.css';

export default function Chat({ chat_id }) {
  const [messages, setMessages] = useState([]);

  function onMessageReceived(aiResponse) {
    setMessages(prevMessages => [...prevMessages, { text: aiResponse, sender: 'AI' }]);
  }

  function onMessageSent(userMessage) {
    setMessages(prevMessages => [...prevMessages, { text: userMessage, sender: 'user' }]);
  }

  return (
    <div className="chat-container">
      <div className="message-container">
        {messages.map((message, index) => (
          <Message key={index} text={message.text} sender={message.sender} />
        ))}
      </div>
      <UserInput chatId={chat_id} onMessageSent={onMessageSent} onMessageReceived={onMessageReceived} />
    </div>
  );
};

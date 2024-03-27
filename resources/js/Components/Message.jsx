import React from 'react';

const Message = ({ text, sender }) => {
  return (
    <div className={`message ${sender === 'AI' ? 'AI' : 'user'}`}>
      <span>{text}</span>
    </div>
  );
};

export default Message;

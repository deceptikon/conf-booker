import React, { Component } from 'react';
import BookingForm from './components/BookingForm';
import logo from './logo.svg';
import './App.css';

const style = {
  margin: '0 auto',
  maxWidth: '640px',
  background: '#BBB',
};

class App extends Component {
  render() {
    return (
      <div className="App" style={style}>
        <BookingForm />
      </div>
    );
  }
}

export default App;

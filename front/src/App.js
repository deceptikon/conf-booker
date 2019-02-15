import React, { Component } from 'react';
import Registration from './components/Registration';
import './App.css';

const style = {
  margin: '0 auto',
  maxWidth: '800px',
  minHeight: '600px',
  background: '#fefefe',
  padding: '60px 10px',
};

class App extends Component {
  render() {
    return (
      <div className="App" style={style}>
        <Registration />
      </div>
    );
  }
}

export default App;

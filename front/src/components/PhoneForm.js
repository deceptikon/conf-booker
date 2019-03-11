import React, { Component } from 'react';
import Paper from '@material-ui/core/Paper';
import Button from '@material-ui/core/Button';
import { PhoneInput } from './BookingForm';


class PhoneForm extends Component {
  state = {
    phone: '',
  };

  submit = e => {
    e.preventDefault();
    this.props.handler(this.state.phone)
  }

  newRegistration = () => {
    this.props.handler(false);
  }

  render() {
    return (
      <Paper style={{padding: '60px 40px'}} >
        <form onSubmit={this.submit}>
          <PhoneInput 
            required id="speciality" label="Введите ваш телефон"
            helperText="в формате 0-555-00-00-00"
            value={this.state.phone}
            onChange={e => this.setState({ phone: e.target.value })}
          />
          <div
            style={{ margin: '10px', display: 'inline-block' }}
          >
            <Button 
              variant="contained" color="secondary" 
              type="submit"
            >
              Продолжить регистрацию
            </Button>
          </div>
          <br />
          <br />
          <br />
          <a href="/register" onClick={this.newRegistration}>Пройти первичную регистрацию</a>
        </form>
      </Paper>
    );
  }
};

export default PhoneForm;

import React, { Component } from 'react';
import Typography from '@material-ui/core/Typography';
import TextField from '@material-ui/core/TextField';
import Paper from '@material-ui/core/Paper';
import Button from '@material-ui/core/Button';
import BookingForm from './BookingForm';

const Intro = ({ handler }) => {
  return (
    <Paper style={{padding: '60px 40px'}} >
      <div className="intro">
      <Typography color="textPrimary" gutterBottom gutterTop variant="h4" component="h1">
            Конференция по каким то радиологическим штукам
          </Typography>
      <Typography gutterBottom gutterTop variant="h5" color="textSecondary" component="h3">
            12 апреля 2019 г.
          </Typography>
      <Typography  gutterTop variant="h6" color="textSecondary" component="div">
        г. Бишкек, ул. Ахунбаева 102/пер. Тыныстанова
          </Typography>
      <div className="intro-text">
        <p> тттттттттттттут текст о конференцииут текст о конференцииут текст о конференцииут текст о конференцииут текст о конференцииут текст о конференцииут текст о конференцииут текст о конференцииут текст о конференцииут текст о конференцииут текст о конференцииут текст о конференцииут текст о конференции 
        </p>
        <p> тттттттттттттут текст о конференцииут текст о конференцииут текст о конференцииут текст о конференцииут текст о конференцииут текст о конференцииут текст о конференцииут текст о конференцииут текст о конференцииут текст о конференцииут текст о конференцииут текст о конференцииут текст о конференции 
        </p>
      </div>
      <Button variant="contained" color="secondary" onClick={e => handler('primary')}>
            Первичная регистрация
          </Button> &nbsp;
          <Button variant="contained" color="primary" onClick={e => handler('secondary')}>
            Я уже зарегистрирован в системе ARKR
          </Button>
        </div>
    </Paper>
  );
};

const PhoneForm = ({ handler }) => {
  return (
    <Paper style={{padding: '60px 40px'}} >
      <TextField 
          required id="speciality" label="Введите ваш телефон" fullWidth 
          helperText="в формате 0-555-000000"
        />
      <Button variant="contained" color="secondary" onClick={e => handler('primary')}>
            Продолжить регистрацию
          </Button> &nbsp;
      </Paper>
  );
};

class Registration extends Component {
  state = {
    registration: null,
  };

  setRegState = state => this.setState({ registration: state });

  render() {
    const { registration } = this.state;

    if(registration === 'primary') {
      return (
        <BookingForm />
      );
    }

    if(registration === 'secondary') {
      return (
        <PhoneForm />
      );
    }

    return (
      <Intro handler={this.setRegState} />
    );
  }
}

export default Registration;

import React from 'react';

import InputMask from 'react-input-mask';
import Typography from '@material-ui/core/Typography';
import Grid from '@material-ui/core/Grid';
import TextField from '@material-ui/core/TextField';
import Button from '@material-ui/core/Button';
import FormControlLabel from '@material-ui/core/FormControlLabel';
import Checkbox from '@material-ui/core/Checkbox';

const PhoneInput = (props) => (
  <InputMask mask="0 (999) 99-99-99" maskChar="_" value={props.value} onChange={props.onChange}>
    {(inputProps) => <TextField {...inputProps} {...props} type="tel" disableUnderline />}
  </InputMask>
);



class BookingForm extends React.Component {
  state = {
    fullname: '',
    phone: '',
    email: '',
    job_place: '',
    position: '',
    address: '',
    degree: '',
    device: '',
  };

  sendForm = (e, val) => {
    console.log(val, e);
    e.preventDefault();
  }

  onChange = (e) => {
    console.log(e, this.state, e.target.name);
    e.persist();
    this.setState({ [e.target.name]: e.target.value });
  }

  render() {
    const { fullname, phone, email, job_place, position, address, degree, device } = this.state;
    return (
      <React.Fragment>
        <form onSubmit={this.sendForm}>
          <Typography variant="h4" gutterBottom>
            Регистрация на конференцию
          </Typography>
          <Grid container spacing={32}>
            <Grid item xs={12} md={12}>
              <TextField required name="fullname" label="Полное имя" value={fullname} onChange={this.onChange} fullWidth />
            </Grid>
            <Grid item xs={6}> 
              <PhoneInput required name="phone" label="Телефон" value={phone} onChange={this.onChange} fullWidth />
            </Grid>
            <Grid item xs={6}>
              <TextField name="email" label="Электронная почта" value={email} onChange={this.onChange} fullWidth />
            </Grid>
            <Grid item xs={6} md={6}>
              <TextField required name="job_place" label="Место работы" value={job_place} onChange={this.onChange} fullWidth />
            </Grid>
            <Grid item xs={6} md={6}>
              <TextField required name="position" label="Должность" value={position} onChange={this.onChange} fullWidth />
            </Grid>
            <Grid item xs={12} md={12}>
              <TextField required name="address" label="Рабочий адрес" value={address} onChange={this.onChange} fullWidth />
            </Grid>
            <Grid item xs={4} md={4}>
              <TextField name="degree" label="Ученая степень" value={degree} onChange={this.onChange} fullWidth helperText="д.м.н., к.м.н. или др." />
            </Grid>
            <Grid item xs={8} md={8}>
              <TextField 
                name="device" label="Наименование аппарата" value={device} onChange={this.onChange} fullWidth 
                helperText="Укажите с каким аппаратом вы работаете"
              />
            </Grid>
            <Grid item xs={12}>
              <FormControlLabel
                control={<Checkbox color="secondary" name="agreed" value="yes" required />}
                label="Согласен на обработку моих личных данных"
              />
              <Button variant="contained" type="submit" color="primary">
                Записаться на конференцию
              </Button>
            </Grid>
          </Grid>
        </form>
      </React.Fragment>
    );
  }
}

export default BookingForm;

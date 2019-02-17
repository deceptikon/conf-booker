import React from 'react';
import { ApolloConsumer } from "react-apollo";
import gql from 'graphql-tag';


import InputMask from 'react-input-mask';
import Typography from '@material-ui/core/Typography';
import Grid from '@material-ui/core/Grid';
import TextField from '@material-ui/core/TextField';
import Button from '@material-ui/core/Button';
import FormControlLabel from '@material-ui/core/FormControlLabel';
import Checkbox from '@material-ui/core/Checkbox';
import Alert from 'react-s-alert';

import { formatPhone } from '../utils';

export const PhoneInput = (props) => (
  <InputMask mask="0 (999) 99-99-99" maskChar="_" value={props.value} onChange={props.onChange}>
    {(inputProps) => <TextField {...inputProps} {...props} type="tel" />}
  </InputMask>
);

const saveMember = gql`
  mutation saveMember($id: Int, $data: UserInput!) {
    User (id: $id, data: $data) {
      fullname
      email
      phone
    }
  }
`


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

  componentDidMount() {
    this.setState({
      ...this.props.data,
    });
  }

  componentDidUpdate(prevProps) {
    if (prevProps.data !== this.props.data) {
      this.setState({
        ...this.props.data,
      });
    }
  }

  sendForm = (e, val) => {
    e.preventDefault();
    this.props.apollo.mutate({
      errorPolicy: "all",
      mutation: saveMember,
      variables: {
        data: {
          ...this.state,
        }
      }
    })
      .then(res => {
        Alert.success(`Регистрация успешна, ${res.data.User.fullname}!`);
        this.props.handler('success')
      })
      .catch(err => {
        console.error("BAD", err);
      });
  }

  onChange = (e) => {
    e.persist();
    if(e.target.name === 'phone') {
      this.setState({ [e.target.name]:  formatPhone(e.target.value) });
    } else {
      this.setState({ [e.target.name]: e.target.value });
    }
  }

  render() {
    const { fullname, phone, email, job_place, position, address, degree, device } = this.state;
    return (
      <React.Fragment>
        <form onSubmit={this.sendForm}>
          <Typography variant="h6" color="primary" gutterBottom>
            {
              this.props.data ? 
                'Подтвердите свои данные для участия в конференции' :
                'Заполните форму для участия в конференции'
            }
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
              {
                !this.props.data && (
                  <FormControlLabel
                    control={<Checkbox color="secondary" name="agreed" value="yes" required />}
                    label="Согласен на обработку моих личных данных"
                  />
                )
              }
              <Button variant="contained" type="submit" color="primary">
                Записаться на конференцию
              </Button> &nbsp;
              <Button color="secondary" onClick={e => this.props.handler('default')}>
                Отменить и назад
              </Button>
            </Grid>
          </Grid>
        </form>
      </React.Fragment>
    );
  }
}

const ApolloBookingForm = (props) => (
  <ApolloConsumer>
    { client => <BookingForm apollo={client} {...props}/> }
  </ApolloConsumer>
);

export default ApolloBookingForm;

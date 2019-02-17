import React, { Component } from 'react';
import { ApolloConsumer } from "react-apollo";
import Paper from '@material-ui/core/Paper';
import gql from 'graphql-tag';
import BookingForm from './BookingForm';
import PhoneForm from './PhoneForm';
import Intro, { InfoBlock } from './Intro';
import { formatPhone } from '../utils';
import Alert from 'react-s-alert';

const findMemberByPhone = gql`
  query findMemberByPhone($phone: String) {
    User (phone: $phone) {
      fullname
      email
      phone
      position
      address
      degree
      device
      job_place
    }
  }
`

class Registration extends Component {
  state = {
    state: 'default',
    res: null,
  };

  setRegState = state => {
    this.setState({ 
      state: state,
      data: state === 'primary' ? null : this.state.data,
    });
  }

  editUser = (data) => {
    if (data) {
      this.props.apollo.query({
        errorPolicy: "all",
        query: findMemberByPhone,
        variables: {
          phone: formatPhone(data),
        }
      })
        .then(res => {
          const data = {};
          console.error(res);
          if (res.data.User) {
            Object.keys(res.data.User[0])
              .filter(key => key !== '__typename')
              .forEach(key => data[key] = res.data.User[0][key]);
            this.setState({
              data,
              state: 'primary',
            });
          } else {
            Alert.error('Пользователь не найден');
          }
        })
        .catch(err => {
          console.error("BAD", err);
        });
    } else {
      this.setState({ state: 'primary' });
    }
  }

  render() {
    const { state } = this.state;

    if(state === 'success') {
      return (
        <Paper style={{padding: '60px 40px'}} >
          <InfoBlock />
          <h3>Регистрация успешна, ожидаем вас на конференции!</h3>
        </Paper>
      );
    }

    if(state === 'primary') {
      return (
        <Paper style={{padding: '60px 40px'}} >
          <InfoBlock />
          <BookingForm
            handler={ state => this.setState({ state })} 
            data={this.state.data}
          />
        </Paper>
      );
    }

    if(state === 'secondary') {
      return (
        <Paper style={{padding: '60px 40px'}} >
          <InfoBlock />
          <PhoneForm handler={this.editUser} />
        </Paper>
      );
    }

    if(state === 'default') {
      return (
        <Intro handler={this.setRegState} />
      );
    }
  }
}

const ApolloRegistration = (props) => (
  <ApolloConsumer>
    { client => <Registration apollo={client} {...props}/> }
  </ApolloConsumer>
);

export default ApolloRegistration;

import React, { Component } from 'react';
import { ApolloConsumer } from "react-apollo";
import Paper from '@material-ui/core/Paper';
import gql from 'graphql-tag';
import BookingForm from './BookingForm';
import PhoneForm from './PhoneForm';
import Intro, { InfoBlock } from './Intro';
import { formatPhone } from '../utils';
import Alert from 'react-s-alert';
import QRCode from 'qrcode.react';

const findMemberByPhone = gql`
  query findMemberByPhone($phone: String) {
    User (phone: $phone) {
      id
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
const pad = function(s, size) {
  while (s.length < (size || 2)) {s = "0" + s;}
  return s;
}
const coder = (id, isMember) => {
  const prefix = isMember ? 1 : 2;
  return `${prefix}${pad(id.toString(), 5)}`;
}

class Registration extends Component {
  state = {
    state: 'default',
    successData: null,
  };

  setRegState = state => {
    this.setState({ 
      state: state,
      data: state === 'primary' ? null : this.state.data,
    });
  }

  editUser = (data, successData = false) => {
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
          if (res.data.User && res.data.User[0]) {
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
    const { state, successData } = this.state;
    if(state === 'success') {
      const code = coder(successData.id, successData.isMember);
      return (
        <Paper style={{padding: '60px 40px'}} >
          <InfoBlock />
          <h3>Регистрация успешна, { successData.fullname  }  ожидаем вас на конференции!</h3>
          <QRCode value={code} size={200} />
          <h3>{ code }</h3>
        </Paper>
      );
    }

    if(state === 'primary') {
      return (
        <Paper style={{padding: '60px 40px'}} >
          <InfoBlock />
          <BookingForm
            handler={ (state, successData) => this.setState({ state, successData })} 
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
    { client => <div style={{ maxWidth: '800px', margin: '0 auto' }}><Registration apollo={client} {...props}/></div> }
  </ApolloConsumer>
);

export default ApolloRegistration;

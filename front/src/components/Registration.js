import React, { Component } from 'react';
import { ApolloConsumer } from "react-apollo";
import Paper from '@material-ui/core/Paper';
import gql from 'graphql-tag';
import BookingForm from './BookingForm';
import PhoneForm from './PhoneForm';
import Intro, { InfoBlock } from './Intro';
import { formatPhone } from '../utils';

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
  };

  setRegState = state => this.setState({ state: state });

  editUser = (data) => {
    if (data) {
      console.log("edit", formatPhone(data));
      this.props.apollo.query({
        errorPolicy: "all",
        query: findMemberByPhone,
        variables: {
          phone: data,
        }
      })
        .then(res => {
          console.log("GOOD", res);
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

    if(state === 'primary') {
      return (
        <Paper style={{padding: '60px 40px'}} >
          <InfoBlock />
          <BookingForm handler={() => this.setState({ state: 'default' })} />
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

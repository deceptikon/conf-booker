import React, { Component } from 'react';
import { ApolloConsumer } from "react-apollo";
import Paper from '@material-ui/core/Paper';
import gql from 'graphql-tag';
import BookingForm from './BookingForm';
import PhoneForm from './PhoneForm';
import Intro, { InfoBlock } from './Intro';
import { formatPhone } from '../utils';

class Registration extends Component {
  state = {
    registration: null,
  };

  setRegState = state => this.setState({ registration: state });

  editUser = (data) => {
    if (data) {
      console.log("edit", formatPhone(data));
    } else {
      this.setState({ registration: 'primary' });
    }
  }

  render() {
    const { registration } = this.state;

    if(registration === 'primary') {
      return (
        <Paper style={{padding: '60px 40px'}} >
          <InfoBlock />
          <BookingForm />
        </Paper>
      );
    }

    if(registration === 'secondary') {
      return (
        <Paper style={{padding: '60px 40px'}} >
          <InfoBlock />
          <PhoneForm handler={this.editUser} />
        </Paper>
      );
    }

    return (
      <Intro handler={this.setRegState} />
    );
  }
}

const ApolloRegistration = (props) => (
  <ApolloConsumer>
    { client => <Registration apollo={client} {...props}/> }
  </ApolloConsumer>
);

export default ApolloRegistration;

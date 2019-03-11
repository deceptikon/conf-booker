import React, { Component } from 'react';
import Paper from '@material-ui/core/Paper';
import Button from '@material-ui/core/Button';
import InputMask from 'react-input-mask';
import TextField from '@material-ui/core/TextField';
import { ApolloConsumer } from "react-apollo";
import gql from 'graphql-tag';
import QrReader from './QrReader';

const recordGuest = gql`
  mutation recordGuest {
    newGuest {
      status
    }
  }
`

export const PinInput = (props) => (
  <InputMask mask="9 9 9 9 9 9" maskChar="_" value={props.value} onChange={props.onChange}>
    {(inputProps) => <TextField {...inputProps} {...props} type="text" />}
  </InputMask>
);

class ViewUsers extends Component {
  state = {
    pin: '',
  };

  submitPin = (e) => {
    e.preventDefault();
    const pin = Number(this.state.pin.replace(/ /g, ''));
    !isNaN(pin) && this.props.apollo.mutate({
        errorPolicy: "all",
        mutation: recordGuest,
        variables: {
          pin, 
        } 
      })
        .then(res => {
          console.error(res);
          if (res.data.User) {
            this.setState({
              users: res.data.User
            });
          }
        })
        .catch(err => {
          console.error("BAD", err);
        });
  }
  
  render() {
    const { users, pin } = this.state;

    if (false && !users) {
      return (<div>Загружается...</div>);
    }
    const p = pin && Number(pin.replace(/ /g,""));
    console.log(p, p && p.length);

    return (
      <Paper style={{padding: '60px 40px'}} >
        <QrReader />
        <form onSubmit={this.submitPin}>
          <PinInput 
            required id="speciality" label="Введите пин гостя"
            value={this.state.pin}
            onChange={e => this.setState({ pin: e.target.value })}
          />
          <div
            style={{ margin: '10px', display: 'inline-block' }}
          >
            <Button 
              variant="contained" color="secondary" 
              type="submit"
              disabled={!p || isNaN(p)}
            >
              OK
            </Button>
          </div>
          <br />
          <br />
          <br />
        </form>
      </Paper>
    );
  }

}
const ApolloRegistration = (props) => (
  <ApolloConsumer>
    { client => <ViewUsers apollo={client} {...props}/> }
  </ApolloConsumer>
);

export default ApolloRegistration;

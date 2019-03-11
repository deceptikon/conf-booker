import React, { Component } from 'react';
import Paper from '@material-ui/core/Paper';
import Button from '@material-ui/core/Button';
import InputMask from 'react-input-mask';
import TextField from '@material-ui/core/TextField';
import { ApolloConsumer } from "react-apollo";
import gql from 'graphql-tag';
import QrReader from './QrReader';

const recordGuest = gql`
  mutation recordGuest($pin: Int!) {
    newGuest(pin: $pin) {
      status
      name
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
    showQr: false,
  };

  submitPin = (e) => {
    e.preventDefault();
    const pin = Number(this.state.pin.replace(/ /g, ''));
    this.setState({
      error: null,
      success: null,
    });
    !isNaN(pin) && this.props.apollo.mutate({
        errorPolicy: "all",
        mutation: recordGuest,
        variables: {
          pin, 
        } 
      })
        .then(res => {
          if (res.data.newGuest.status === 'ok') {
            console.error(res);
            this.setState({
              success: `Участник ${res.data.newGuest.name} подтвержден`,
              error: null,
              showQr: false,
              pin: '',
            });
          } else {
            this.setState({
              success: null,
              error: "Гость не найден",
              showQr: false,
            });
          }
        })
        .catch(err => {
          console.error("BAD GUEST REQUEST: ", err);
        });
  }
  
  render() {
    const { users, pin, showQr, error, success } = this.state;

    if (false && !users) {
      return (<div>Загружается...</div>);
    }
    const p = pin && Number(pin.replace(/ /g,""));
    console.log(p, p && p.length);

    return (
      <Paper style={{padding: '60px 40px', maxWidth: '600px', margin: '0 auto', }} >
        <Button 
          variant="contained" 
          color={ !showQr ? 'primary' : 'secondary' }
          type="button"
          fullWidth
          style={{ fontSize: showQr ? '12px' : '30px' }}
          size={ !showQr ? 'large' : 'small' }
          onClick={e => this.setState({showQr: !showQr})}
        >
          { showQr ? 'Остановить считывание' : 'Считать QR-код' } 
        </Button>
        {
          showQr && <QrReader />
        }
        <p>
          <small>или</small>
        </p>
        { error && <div className="error">{ error }</div> }
        { success && <div className="success">{ success }</div> }
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

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
      isMember
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
    isMember: false,
    showQr: false,
  };

  submitPin = (e = null) => {
    e && e.preventDefault();
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
              isMember: res.data.newGuest.isMember,
              showQr: false,
              pin: '',
            });
          } else {
            this.setState({
              success: null,
              isMember: false,
              error: "Гость не найден",
              showQr: false,
            });
          }
        })
        .catch(err => {
          console.error("BAD GUEST REQUEST: ", err);
        });
  }

  successHandler = (pin) => {
    console.log("Success Handler called: ", pin);
    this.setState({ pin, showQr: false }, () => this.submitPin()); 
  }

  showIsMember = (isMember) => {
    if(isMember) { 
      return (<div style={{fontSize: '35px', color: 'teal' }}>✔</div>)
    } else {
      return <small style={{color: 'orange'}}><strong>Требуется оплата</strong></small>
    }
  };
  
  render() {
    const { users, pin, showQr, error, success, isMember } = this.state;

    console.log("isMember: ", this.state.isMember);

    if (false && !users) {
      return (<div>Загружается...</div>);
    }
    const p = pin && Number(pin.replace(/ /g,""));

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
          showQr && <QrReader successHandler={this.successHandler}/>
        }
        { error && <div className="error">{ error }</div> }
        { success && <div className="success">{ success }</div> }
        {
          success && this.showIsMember(isMember)
        }
        <br/>
        <br/>
        <br/>
        <hr/>
        <p>
          <small>или если код не считывается</small>
        </p>
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

import React, { Component } from 'react';
import Paper from '@material-ui/core/Paper';
import { ApolloConsumer } from "react-apollo";
import gql from 'graphql-tag';

import { withStyles } from '@material-ui/core/styles';

import Table from '@material-ui/core/Table';
import TableBody from '@material-ui/core/TableBody';
import TableCell from '@material-ui/core/TableCell';
import TableHead from '@material-ui/core/TableHead';
import TableRow from '@material-ui/core/TableRow';

const allUsers = gql`
  query allUsers {
    User {
      fullname
      email
      phone
      position
      address
      degree
      device
      job_place
      is_member
    }
  }
`
const CustomTableCell = withStyles(theme => ({
  head: {
    backgroundColor: theme.palette.common.black,
    color: theme.palette.common.white,
  },
  body: {
    fontSize: 14,
  },
}))(TableCell);

const styles = theme => ({
  root: {
    width: '100%',
    marginTop: theme.spacing.unit * 3,
    overflowX: 'auto',
  },
  table: {
    minWidth: 700,
  },
  row: {
    '&:nth-of-type(odd)': {
      backgroundColor: theme.palette.background.default,
    },
  },
});

const User = ({data}) => {
  return (
    <div>{ data.fullname }</div>
  );
};

class ViewUsers extends Component {
  state = {
    users: null,
  };

  componentDidMount() {
    this.props.apollo.query({
        errorPolicy: "all",
        query: allUsers,
      })
        .then(res => {
          const data = {};
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
    const { users } = this.state;
    const { classes } = this.props;

    if (!users) {
      return (<div>Загружается...</div>);
    }

    return (
      <div style={{padding: '15px', background: '#EFEFEF'}}>
        {
          <Table className="table"  style={{ fontSize: '11px'}}>
            <TableHead>
              <TableRow>
                <CustomTableCell>ФИО</CustomTableCell>
                <CustomTableCell align="right">Должность</CustomTableCell>
                <CustomTableCell align="right">Место работы</CustomTableCell>
                <CustomTableCell align="right">Адрес работы</CustomTableCell>
                <CustomTableCell align="right">Аппарат</CustomTableCell>
                <CustomTableCell align="right">Член</CustomTableCell>
              </TableRow>
            </TableHead>
            <TableBody>
              {users.map(row => (
                <TableRow key={row.id}>
                  <CustomTableCell component="th" scope="row">
                    {row.fullname}
                  </CustomTableCell>
                  <CustomTableCell align="right">{row.position}</CustomTableCell>
                  <CustomTableCell align="right">{row.job_place}</CustomTableCell>
                  <CustomTableCell align="right">{row.address}</CustomTableCell>
                  <CustomTableCell align="right">{row.device}</CustomTableCell>
                  <CustomTableCell align="right">{row.is_member ? 'ДА' : '-' }</CustomTableCell>
                </TableRow>
              ))}
            </TableBody>
          </Table>
        }
      </div>
    );
  }

}
const ApolloRegistration = (props) => (
  <ApolloConsumer>
    { client => <ViewUsers apollo={client} {...props}/> }
  </ApolloConsumer>
);

export default ApolloRegistration;
